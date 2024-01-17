<?php

class Model_users extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}




	public function select_user( array $search ): array
	{
		$this->sdb->select( '
            user_no,
			name
        ' );

		if( !empty( $search['user_no'] ) )   //(안에 내용이있으면)
		{
			$this->sdb->where( 'user_no', $search['user_no'] );
		}

		if( !empty( $search['name'] ) )
		{
			$this->sdb->where( 'name', $search['name'] );
		}

		$query = $this->sdb->get( USER_INFO );
		# 데이터베이스가 들어가 있다고?

		if( $query )
		{
			if( $query->num_rows() > 0 )
			{
				$order_info = NULL;

				foreach( $query->result() as $row )
				{
					$order_info = [
						'user_no'       => $row->user_no,
						'name'     		=> $row->name,
					];
				}

				return $order_info;
			}
			else
			{
				return [];
			}
		}
		else
		{
			throw new Db_exception( ['message' => $this->sdb->_error_message(), 'code' => $this->sdb->_error_number()] );
		}
	}

	public function insert_user( $data )
	{
		$insert_data = [
			'name' 		=> $data['name'],
			'passwd' 	=> $data['passwd'],
			'address' 	=> $data['address'],
			'birth'		=> $data['birth'],
			'user_id'	=> $data['user_id'],
		];

		if( !$this->mdb->insert( USER_INFO, $insert_data ) )
		{
			throw new Db_exception( ['message' => $this->mdb->_error_message(), 'code' => $this->mdb->_error_number()] );
		}

		return $this->mdb->insert_id();
	}

	public function update_user( int $userNo, string $userName ): bool
	{
		$update_data = [
			'name' => $userName
		];
		# 키는 항상 컬럼명
		$this->mdb->where( 'user_no', $userNo );

		if( !$this->mdb->update( USER_INFO, $update_data ) )
		{
			throw new Db_exception( ['message' => $this->mdb->_error_message(), 'code' => $this->mdb->_error_number()] );
		}

		return TRUE;
	}


	public function delete_user( int $userNo ): bool
	{
		# 키는 항상 컬럼명
		$this->mdb->where( 'user_no', $userNo );
		#whre id = 'userNo'

		if( !$this->mdb->delete( USER_INFO ))
		{
			throw new Db_exception( ['message' => $this->mdb->_error_message(), 'code' => $this->mdb->_error_number()] );
		}

		return TRUE;


	}


}

#직접적인 쿼리문
#https://ciboard.co.kr/user_guide/kr/database/examples.html
#쿼리문에 대한 자세한 내용은 위의 사이트에서 확인이 가능하다