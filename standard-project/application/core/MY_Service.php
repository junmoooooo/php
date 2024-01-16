<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * Common Base Service Class
     *
     * ex) $this->load->service('user_service');        // 서비스로딩
     *     $this->user_service->get_user_info_list();   // 서비스사용
     *
     * @package
     * @subpackage
     * @category
     * @author sasem2k
     * @link
     */
    class MY_Service
    {
        /**
         * 생성자
         *
         */
        public function __construct()
        {
        }

        /**
         * CI property를 가져온다.
         *
         * @param $key property
         *
         * @return mixed
         */
        public function __get($key)
        {
            $CI = & get_instance();
            return $CI->$key;
        }
    }

    /* End of file MY_Service.php */
    /* Location: ./application/core/MY_Service.php */
