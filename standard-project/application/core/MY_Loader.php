<?php ( defined('BASEPATH') ) OR exit('No direct script access allowed');

    /* load the MX_Loader class */
    require APPPATH . "third_party/MX/Loader.php";

    class MY_Loader extends MX_Loader
    {
        /**
         * 서비스 목록
         *
         * @var array
         * @access protected
         */
        protected $_ci_services = [];

        /**
         * 서비스 경로 목록
         *
         * @var array
         * @access protected
         */
        protected $_ci_service_paths = [
            APPPATH,
            BASEPATH
        ];

        /**
         * 생성자
         *
         */
        public function __construct()
        {

            parent::__construct();
            load_class('Service', 'core');

            log_message('info', sprintf('[%s] MY_Loader Class Initialized.', __METHOD__));
        }

        /**
         * 패키지 경로를 추가한다.
         *
         * @param string $path 추가할 경로
         * @param bool   $view_cascade
         *
         * @return object
         */
        public function add_package_path($path, $view_cascade = TRUE)
        {
            parent::add_package_path($path, $view_cascade);

            $path = rtrim($path, '/') . '/';

            array_unshift($this->_ci_service_paths, $path);

            return $this;
        }

        public function database($params = '', $return = FALSE, $active_record = NULL)
        {
            // Grab the super object
            $CI = &get_instance();

            // Do we even need to load the database class?
            if( class_exists('CI_DB') AND $return == FALSE AND $active_record == NULL AND isset($CI->db) AND is_object($CI->db) )
            {
                return FALSE;
            }

            require_once( BASEPATH . 'database/DB.php' );

            $db = DB($params, $active_record);

            // Load extended DB driver
            $custom_db_driver      = config_item('subclass_prefix') . 'DB_' . $db->dbdriver . '_driver';
            $custom_db_driver_file = APPPATH . 'core/' . $custom_db_driver . '.php';

            if( file_exists($custom_db_driver_file) )
            {
                require_once( $custom_db_driver_file );

                $db = new $custom_db_driver(get_object_vars($db));
            }

            // Return DB instance
            if( $return === TRUE )
            {
                return $db;
            }

            // Initialize the db variable. Needed to prevent reference errors with some configurations
            $CI->db = '';
            $CI->db = &$db;
        }

        /**
         * 서비스를 로드한다.
         *
         * @param string $service     서비스 클래스명
         * @param mixed  $params      서비스 파라미터
         * @param string $object_name 서비스 오브젝트명
         *
         * @return $this
         */
        public function service($service, $params = NULL, $object_name = NULL)
        {
            if( is_array($service) )
            {
                return $this->service($service);
            }

            $class = strtolower(basename($service));

            if( isset($this->_ci_services[$class]) && $_alias = $this->_ci_services[$class] )
            {
                return $this;
            }

            ( $_alias = strtolower($object_name) ) OR $_alias = $class;

            list($path, $_service) = Modules::find($service, $this->_module, 'services/');

            if( $path === FALSE )
            {
                $subdir = '';

                if( ( $last_slash = strrpos($service, '/') ) !== FALSE )
                {
                    $subdir = substr($service, 0, ++$last_slash);
                }

                $service = ucfirst($class);
                foreach( $this->_ci_service_paths as $path )
                {
                    $filepath = $path . 'services/' . $subdir . $service . '.php';

                    if( !file_exists($filepath) )
                    {
                        continue;
                    }

                    include_once( $filepath );

                    CI::$APP->$_alias = new $service($params);

                    $this->_ci_services[$class] = $_alias;

                    return $this;
                }
            }
            else
            {
                Modules::load_file($_service, $path);

                $service = ucfirst($_service);

                CI::$APP->$_alias = new $service($params);

                $this->_ci_services[$class] = $_alias;
            }

            return $this;
        }
    }
