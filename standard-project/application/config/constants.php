<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

// 날짜, 시간 상수
define('TIME_YMD', date('Y-m-d', time()));
define('TIME_HIS', date('H:i:s', time()));
define('TIME_YMDHIS', date('Y-m-d H:i:s', time()));

// 공통 에러 코드 정의
define('SUCCESS', '100');                                       // 성공

define('NOT_FOUND', '70101');                                   // 잘못된 요청으로 메서드를 찾지 못함
define('UNAUTHORIZED', '70102');                                // Header에 Authorization이 없거나 JWT 기간 만료
define('JWT_VERIFICATION_FAILED', '70103');                     // JWT 검증 실패
define('PAYLOAD_VERIFICATION_FAILED', '70104');                 // payload가 잘못됨
define('SERVICE_VERIFICATION_FAILED', '70105');                 // 서비스 정보가 조회 불가
define('BAD_REQUEST', '70106');                                 // 파라미터의 형태가 잘못되었거나 필수 파라미터가 누락된 경우
define('INTERNAL_SERVER_ERROR', '70107');                       // 서버에 에러가 발생하여 응답 할 수 없는 경우

// 주문 관련 에러
define('UNCONFIRMED_ORDER', '70201');                           // 지급 결과 처리 중, 주문정보 조회 실패
define('UNCONFIRMED_PAYMENT_RESULT', '70202');                  // 결제 결과 처리 대기중 (아임포트에서 주문 결과가 오지 않음)
define('CANCEL_PAYMENT', '70203');                              // 결제가 취소된 주문 입니다.
define('SUSPECTED_TAMPERING', '70204');                         // 위 변조 (조작) 이 의심됨
define('ORDERS_THAT_HAVE_ALREADY_BEEN_CANCELED', '70205');      // 이미 취소된 주문 입니다.

// 0: 주문 접수, 1: 결제성공, 2: IAP와 아임포트의 주문정보가 다름, 3: 결제 취소, 4: 결제 실패, 5: 결제 예약, 6: 가상계좌 발급
define('ORDER_RECEPTION', 0);                                   // 주문 접수
define('ORDER_PAID', 1);                                        // 결제성공
define('ORDER_COUNTERFEIT', 2);                                 // 위변조 의심
define('ORDER_CANCELED', 3);                                    // 주문 취소
define('ORDER_FAILED', 4);                                      // 결제 실패
define('ORDER_RESERVATION', 5);                                 // 결제 예약
define('ORDER_VBANK_READY', 6);                                 // 가상 계좌 발급 및 결제 대기

define('FINISHED_READY', 0);                                    // 지급 완료 처리 전 대기 상태
define('FINISHED_COMPLETE', 1);                                 // 지급 완료
define('FINISHED_FAILED', 2);                                   // 지급 실패