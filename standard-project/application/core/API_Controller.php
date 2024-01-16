<?php ( defined( 'BASEPATH' ) ) or exit( 'No direct script access allowed' );

use chriskacerguis\RestServer\RestController;

// 공통으로 사용할것들을 묶어둔곳
class API_Controller extends RestController
{
    /**
	 * @throws \Import_exception
	 * @throws \Db_exception
	 */
	public function __construct()
    {
        parent::__construct();
        $this->load->helper( 'form_helper' );
        $this->load->library( 'Data_validation' );
    }

    public function errorResponse()
    {
        $this->dataResponse( [
            'code'    => NOT_FOUND,
            'message' => $this->lang->line( 'NOT_FOUND' )
        ] );
    }

    public function dataResponse( $response )
    {
        header( 'Content-Type: application/json' );
        $response['code'] = (string)$response['code'];
        echo( json_encode( $response, TRUE ) );
    }

}
/* The MX_Controller class is autoloaded as required */
