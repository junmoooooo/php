<?php if( !defined('BASEPATH') )
{
    exit('No direct script access allowed');
}

    class MY_Model extends CI_Model
    {

        // 공통으로 사용할 DB
        public $mdb = NULL;
        public $sdb = NULL;
        public $bdb = NULL;

        /**
         * Constructor
         *
         * @access public
         */
        function __construct()
        {
            $CI =& get_instance();

            $this->mdb = $this->load->database('master', TRUE);
            $this->mdb->initialize();

            $this->sdb = clone $this->mdb;
            $this->bdb = clone $this->mdb;
        }

    }
    // END Model Class

    /* End of file Model.php */
    /* Location: ./system/core/Model.php */
