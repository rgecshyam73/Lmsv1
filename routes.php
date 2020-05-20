<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// echo phpinfo();
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
|	https://codeigniter.com/user_guide/general/routing.html
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
/*$user = $this->session->userdata('user_details');
print_r($user);*/
//print_r($_SESSION['user_details'][0]->role_id);

$id=$this->uri->segment(2);
$tId=$this->uri->segment(3);
$request_type=$this->uri->segment(4); //exit;
$route['default_controller'] = 'welcome';
$route['register'] = 'welcome/Register';
//print_r($route);die;

/************* User Links Start From here **********************/

$route['dashboard/:num'] = 'UserPublic_digital_library1/dashboardcount/'.$id;
$route['organisation_login'] = 'UserPublic_digital_library1/organisation_login';
$route['user_login'] = 'UserPublic_digital_library1/user_login';
$route['my_learning_plan'] = 'UserPublic_digital_library1/my_learning_plan';
$route['get_my_profile'] = 'UserPublic_digital_library1/get_my_profile';
$route['getAssessmentDetail'] = 'UserPublic_digital_library1/getAssessmentDetail';
$route['getQuestion'] = 'UserPublic_digital_library1/getStartQuestion';