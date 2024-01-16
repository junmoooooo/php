<?php
defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller']   = 'welcome';
$route['404_override']         = '';
$route['translate_uri_dashes'] = FALSE;

// Restfull API Routes
$route['users/(:num)']['GET']                           = 'users/findUserNo/$1';                // 유저 고유번호를 이용한 정보 조회
$route['users/name/(:any)']['GET']                      = 'users/findUserName/$1';              // 유저 이름을 이용한 정보 조회
$route['users/(:num)/name']['PATCH']                    = 'users/patchUserName/$1';             // 유저 고유번호를 이용한 정보 조회
$route['users']['POST']                                 = 'users/insertUser';
$route['users/(:num)']['DELETE']                        = 'users/deleteUser/$1';

$route['characters/(:num)']['GET']                           = 'characters/findChNo/$1';    
$route['characters']['POST']                                 = 'characters/insertCharacter';


// uri는 어떻게 받겠다라는걸 지정해줌
// PATCH 파라미터로 'users/patchUserName/$1/$2' 클래스 public function patchUserName_patch($userNo, $userName) 순서대로 들어감
