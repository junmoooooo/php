<?php ( defined( 'BASEPATH' ) ) or exit( 'No direct script access allowed' );

/**
 *
 * 공통 라이브러리를 property를 지정해주시면,
 * 보다 편리하게 코딩이 가능합니다.
 * ctrl + space 가능
 *
 * @property Data_validation $Data_validation
 * @property pagination      $pagination
 */
class MY_Controller extends CI_Controller
{
	public function __construct()
	{

		parent::__construct();

		/*
		 * 공통 라이브러리 및 헬퍼는 생성자 함수에 추가하세요.
		 */
		$this->load->helper( 'form_helper' );
		$this->load->library( 'Data_validation' );
		$this->load->library( 'user_agent' );
	}

	/**
	 * error
	 *
	 * @author      until
	 * @date        2022-02-22
	 * @description 에러 로그를 남기고 에러 페이지로 이동함
	 *
	 * @param        $log_title
	 * @param        $log_message
	 * @param int    $status_code
	 * @param string $heading
	 * @param string $message
	 */
	public function error( $log_title = NULL, $log_message = NULL, int $status_code = 200, string $heading = 'ERROR', string $message = 'Ooops!!' ): void
	{
		if( !empty( $log_title ) && !empty( $log_message ) )
		{
			log_message( 'error', sprintf( '[%s] ' . $log_title . '=[%s]', __METHOD__, $log_message ) );
		}

		show_error( $message, $status_code, $heading );
	}

}
/* The MX_Controller class is autoloaded as required */
