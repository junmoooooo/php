<?php if( !defined( 'BASEPATH' ) )
{
    exit( 'No direct script access allowed' );
}

class HashEncryptionLibrary
{
    // TODO : /game/www/env 에 설정 파일로 추가 하도록 해야함
    private $_password = 'HIVE-SPREADS-OUT-INTO-THE-WORLD';

    function __construct()
    {
        //$this->CI =& get_instance();
    }

    /**
     * encrypted
     *
     * @author      until
     * @date        2021-10-19
     * @description 데이터를 암호화 함 (양방향, 비공개키)
     *
     * @param $data : String
     *
     * @return string
     */
    public function encrypted( $data )
    {
        $password = $this->_get_password();

        // 암호화
        return base64_encode( openssl_encrypt( $data, 'aes-256-cbc', $password['password'], OPENSSL_RAW_DATA, $password['iv'] ) );
    }

    /**
     * decrypted
     *
     * @author      until
     * @date        2021-10-19
     * @description encrypted 로 암호화된 문자열을 암호를 풀어서 보내줌
     *
     * @param $data String 암호화된 문자열
     *
     * @return false|string
     */
    public function decrypted( $data )
    {
        $password = $this->_get_password();

        // 복호화
        return openssl_decrypt( base64_decode( $data ), 'aes-256-cbc', $password['password'], OPENSSL_RAW_DATA, $password['iv'] );
    }

    /**
     * _get_password
     *
     * @author      until
     * @date        2021-10-19
     * @description 비공개 키를 활용하여 비밀번호를 Hash 하고 vi를 생성함
     *
     * @param $password
     *
     * @return array
     */
    private function _get_password()
    {
        $password = hash( 'sha256', $this->_password, TRUE );

        // Initial Vector(IV)는 128 bit(16 byte)입니다.
        $iv = chr( 0x0 ) . chr( 0x0 ) . chr( 0x0 ) . chr( 0x0 ) . chr( 0x0 ) . chr( 0x0 ) . chr( 0x0 ) . chr( 0x0 ) . chr( 0x0 ) . chr( 0x0 ) . chr( 0x0 ) . chr( 0x0 ) . chr( 0x0 ) . chr( 0x0 ) . chr( 0x0 ) . chr( 0x0 );

        return ['password' => $password, 'iv' => $iv];
    }

    /**
     * generate_receipt
     *
     * @author      until
     * @date        2021-10-27
     * @description 아임포트에서 결제 완료 메시지가 오면 해당 정보들을 이용하여 검증에 필요한 hash 데이터를 생성
     */
    public function generate_hash_receipt( $data )
    {
        $data = $data['order_id'] . $data['price'] . $data['currency'] . $data['market_pid'] . $data['appid'];

        return base64_encode( hash( 'sha256', $data . $this->_password, TRUE ) );
    }
}
