<?php
defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );

class Characters extends API_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model( 'Model_characters' );     # 데이터베이스? class명을 명시
	}

	public function patchChName_patch( $chNo )			#파라미터가 들어가는 순서도 중요함!
	{
		$this->data_validation->clear();

		$req_param = [
			'ch_no'	=> $chNo,
			'ch_nickname'  => $this->patch('ch_nickname'),
		];

		// 필수 항목    보안적으로...
		$this->data_validation->set_rules( 'ch_nickname', '', 'trim|xss_clean|required' );
		$this->data_validation->set_rules( 'ch_no', '', 'trim|xss_clean|numeric|required' );
		
		try
		{
			// 요청 파라미터 검증
			$req_param = $this->data_validation->validate( $req_param );

			// 초기값 세팅
			$data = NULL;

			#유저가 있는지 없는지 확인하는거 넣어주자
			
			if( $this->Model_characters->select_ch( [ $req_param['ch_no']] ) )
			{
				$this->Model_characters->update_ch($req_param['ch_no'], $req_param['ch_nickname']);
			
			// 응답 코드 작성
				$response = [
					'code'     => SUCCESS,
					'message'  => 'SUCCESS',
					'request'  => $req_param,
				];
			}
			else
			{
				$response = [
					'code'     => 204,
					'message'  => 'NO_CONTENT',
					'request'  => $req_param,
				];
			}

			// update가 실패하면 데이터베이스 오류로보내자

		}
		catch( Validation_Exception $e )
		{
			// 요청 파라미터 에러
			$response['code']    = BAD_REQUEST;
			$response['message'] = $this->lang->line( 'BAD_REQUEST' );
			$response['request'] = $req_param;

			log_message( 'exception', sprintf( '[%s] Validation_Exception=[%s]', __METHOD__, $e->getMessage() ) );
		}
		catch( Db_exception $e )
		{
			// DB 오류
			$response['code']    = INTERNAL_SERVER_ERROR;
			$response['message'] = $this->lang->line( 'INTERNAL_SERVER_ERROR' );
			$response['request'] = $req_param;

			log_message( 'exception', sprintf( '[%s] Db_exception=[%s]', __METHOD__, $e->getMessage() ) );
		}
		catch( Application_exception $e )
		{
			$response['code']    = $e->getCode();
			$response['message'] = $e->getMessage();
			$response['request'] = $req_param;

			log_message( 'exception', sprintf( '[%s] Application_exception=[%s]', __METHOD__, $e->getMessage() ) );
		}

		$this->dataResponse( $response );

	}


	public function insertCharacter_post()			
	{
		$this->data_validation->clear();

		$req_param = [
			'ch_nickname'  	=> $this->post('ch_nickname'),
			'user_no' 		=> $this->post('user_no'),
		];

		// // 필수 항목    보안적으로...
		$this->data_validation->set_rules( 'ch_nickname', '', 'trim|xss_clean|required' );
		$this->data_validation->set_rules( 'user_no', '', 'trim|xss_clean|numeric|required' );
		
		try
		{
			// 요청 파라미터 검증
			$req_param = $this->data_validation->validate( $req_param );

			$chNo = $this->Model_characters->insert_ch( $req_param);
			// 초기값 세팅

			$response = [
				'code'     => SUCCESS,
				'message'  => 'SUCCESS',
				'response' => ['ch_no' => $chNo],
				'request'  => $req_param,
			];

			// update가 실패하면 데이터베이스 오류로보내자

		}
		catch( Validation_Exception $e )
		{
			// 요청 파라미터 에러
			$response['code']    = BAD_REQUEST;
			$response['message'] = $this->lang->line( 'BAD_REQUEST' );
			$response['request'] = $req_param;

			log_message( 'exception', sprintf( '[%s] Validation_Exception=[%s]', __METHOD__, $e->getMessage() ) );
		}
		catch( Db_exception $e )
		{
			// DB 오류
			$response['code']    = INTERNAL_SERVER_ERROR;
			$response['message'] = $this->lang->line( 'INTERNAL_SERVER_ERROR' );
			$response['request'] = $req_param;

			log_message( 'exception', sprintf( '[%s] Db_exception=[%s]', __METHOD__, $e->getMessage() ) );
		}
		catch( Application_exception $e )
		{
			$response['code']    = $e->getCode();
			$response['message'] = $e->getMessage();
			$response['request'] = $req_param;

			log_message( 'exception', sprintf( '[%s] Application_exception=[%s]', __METHOD__, $e->getMessage() ) );
		}

		$this->dataResponse( $response );

	}

	//var_dumps()

	public function deleteCh_delete( $chNo )   
	{
		$this->data_validation->clear();

		$req_param = [
			'ch_no' => $chNo,
		];

		// 필수 항목    보안적으로...
		$this->data_validation->set_rules( 'ch_no', '', 'trim|xss_clean|numeric|required' );
		
		try
		{
			// 요청 파라미터 검증
			$req_param = $this->data_validation->validate( $req_param );

			// 모델을이용한 유저정보 삭제
			$this->Model_characters->delete_ch( $req_param['ch_no'] );

			// 응답 코드 작성
			$response = [
				'code'     => SUCCESS,
				'message'  => 'SUCCESS' ,
				'response' => ['ch_no' => $chNo],
				'request'  => $req_param,
			];
		}
		catch( Validation_Exception $e )
		{
			// 요청 파라미터 에러
			$response['code']    = BAD_REQUEST;
			$response['message'] = $this->lang->line( 'BAD_REQUEST' );
			$response['request'] = $req_param;

			log_message( 'exception', sprintf( '[%s] Validation_Exception=[%s]', __METHOD__, $e->getMessage() ) );
		}
		catch( Db_exception $e )
		{
			// DB 오류
			$response['code']    = INTERNAL_SERVER_ERROR;
			$response['message'] = $this->lang->line( 'INTERNAL_SERVER_ERROR' );
			$response['request'] = $req_param;

			log_message( 'exception', sprintf( '[%s] Db_exception=[%s]', __METHOD__, $e->getMessage() ) );
		}
		catch( Application_exception $e )
		{
			$response['code']    = $e->getCode();
			$response['message'] = $e->getMessage();
			$response['request'] = $req_param;

			log_message( 'exception', sprintf( '[%s] Application_exception=[%s]', __METHOD__, $e->getMessage() ) );
		}

		$this->dataResponse( $response );
	}
	







	public function findChNo_get( $ch_No )
	{
		$this->data_validation->clear();

		$req_param = [
			'ch_No' => $ch_No,
		];

		// 필수 항목    보안적으로...
		$this->data_validation->set_rules( 'ch_No', '', 'trim|xss_clean|numeric|required' );
		
		try
		{
			// 요청 파라미터 검증
			$req_param = $this->data_validation->validate( $req_param );

			// 초기값 세팅
			$data = NULL;

			// $select_user = $this->Model_users->select_user( $req_param );
			$select_ch = $this->Model_characters->select_ch( $req_param );
			

			if( $select_ch )
			{
				$data = $select_ch;
			}

			// 응답 코드 작성
			$response = [
				'code'     => SUCCESS,
				'message'  => 'SUCCESS' ,
				'response' => $data,
				'request'  => $req_param,
			];
		}
		catch( Validation_Exception $e )
		{
			// 요청 파라미터 에러
			$response['code']    = BAD_REQUEST;
			$response['message'] = 'BAD_REQUEST';
			$response['request'] = $req_param;

			log_message( 'exception', sprintf( '[%s] Validation_Exception=[%s]', __METHOD__, $e->getMessage() ) );
		}
		catch( Db_exception $e )
		{
			// DB 오류
			$response['code']    = INTERNAL_SERVER_ERROR;
			$response['message'] = $this->lang->line( 'INTERNAL_SERVER_ERROR' );
			$response['request'] = $req_param;

			log_message( 'exception', sprintf( '[%s] Db_exception=[%s]', __METHOD__, $e->getMessage() ) );
		}
		catch( Application_exception $e )
		{
			$response['code']    = $e->getCode();
			$response['message'] = $e->getMessage();
			$response['request'] = $req_param;

			log_message( 'exception', sprintf( '[%s] Application_exception=[%s]', __METHOD__, $e->getMessage() ) );
		}

		$this->dataResponse( $response );
	}
}
