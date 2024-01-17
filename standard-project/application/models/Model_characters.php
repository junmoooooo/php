<?php

class Model_characters extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}



	public function select_ch( array $search ): array
	{
		$this->sdb->select( '
            *
        ' );

		if( !empty( $search['ch_no'] ) )   //(안에 내용이있으면)
		{
			$this->sdb->where( 'ch_no', $search['ch_no'] );
		}

		if( !empty( $search['ch_nickname'] ) )
		{
			$this->sdb->where( 'ch_nickname', $search['ch_nickname'] );
		}

		$query = $this->sdb->get( CHARAC_INFO );
		# 데이터베이스가 들어가 있다고?

		if( $query )
		{
			if( $query->num_rows() > 0 )
			{
				$order_info = NULL;

				foreach( $query->result() as $row )
				{
					$order_info = [
						'ch_no'       			=> $row->ch_no,
						'ch_nickname'     		=> $row->ch_nickname,
						'level'					=> $row->level,
						'class'					=>$row->class,
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


	public function insert_ch( $data )
	{
		$insert_data = [
			'ch_nickname' 		=> $data['ch_nickname'],
			'user_no' 			=> $data['user_no'],
		];

		if( !$this->mdb->insert( CHARAC_INFO, $insert_data ) )
		{
			throw new Db_exception( ['message' => $this->mdb->_error_message(), 'code' => $this->mdb->_error_number()] );
		}

		return $this->mdb->insert_id();
	}




	public function update_ch( int $ch_no, string $chname ): bool
	{
		$update_data = [
			'ch_nickname' => $chname
		];
		# 키는 항상 컬럼명
		$this->mdb->where( 'ch_no', $ch_no );

		if( !$this->mdb->update( CHARAC_INFO, $update_data ) )
		{
			throw new Db_exception( ['message' => $this->mdb->_error_message(), 'code' => $this->mdb->_error_number()] );
		}

		return TRUE;
	}


	public function delete_ch( int $chNo ): bool
	{
		# 키는 항상 컬럼명
		$this->mdb->where( 'ch_no', $chNo );
		#whre id = 'userNo'

		if( !$this->mdb->delete( CHARAC_INFO ))
		{
			throw new Db_exception( ['message' => $this->mdb->_error_message(), 'code' => $this->mdb->_error_number()] );
		}

		return TRUE;


	}


}

#직접적인 쿼리문