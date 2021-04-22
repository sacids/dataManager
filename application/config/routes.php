<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
| When you set this option to TRUE, it will replace ALL dashes with
| underscores in the controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'web';
$route['about'] = 'web/about';
$route['create-project'] = 'web/create_project';
$route['collect-data'] = 'web/collect_data';
$route['analyze-data'] = 'web/analyze_data';

$route['formList'] = 'xform/form_list';
$route['submission'] = 'xform/submission';
$route['blog'] = 'blog/post';
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';
$route['open_source_licenses'] = 'welcome/open_source_licenses';

//ohkr
$route['ohkr/diseases'] = 'ohkr/disease_list';
$route['ohkr/diseases/add_new'] = 'ohkr/add_new_disease';
$route['ohkr/diseases/edit/(:num)'] = 'ohkr/edit_disease/$1';
$route['ohkr/diseases/delete/(:num)'] = 'ohkr/delete_disease/$1';

$route['ohkr/species'] = 'ohkr/species_list';
$route['ohkr/species/add_new'] = 'ohkr/add_new_specie';
$route['ohkr/species/edit/(:num)'] = 'ohkr/edit_specie/$1';
$route['ohkr/species/delete/(:num)'] = 'ohkr/delete_specie/$1';

$route['ohkr/symptoms'] = 'ohkr/symptoms_list';
$route['ohkr/symptoms/add_new'] = 'ohkr/add_new_symptom';
$route['ohkr/symptoms/edit/(:num)'] = 'ohkr/edit_symptom/$1';
$route['ohkr/symptoms/delete/(:num)'] = 'ohkr/delete_symptom/$1';

$route['ohkr/disease_symptoms/(:num)'] = 'ohkr/disease_symptoms_list/$1';

//Forms controller
//$route['xform/formList'] = 'xform/form_list';

//error routes
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
