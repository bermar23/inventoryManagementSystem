<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['reports'] = 'reports';
//$route['reports/itemName'] = 'reports/itemName';
$route['reports/search'] = 'reports/search';
$route['transaction/location_name'] = 'transaction/location_name';
$route['transaction/item_code'] = 'transaction/item_code';
$route['transaction/adjust_search'] = 'transaction/adjust_search';
$route['transaction/get_location_details'] = 'transaction/get_location_details';
$route['transaction/update_item'] = 'transaction/update_item';
$route['transaction/add_item'] = 'transaction/add_item';

$route['adjustement/add_adjustement_item'] = 'adjustement/add_adjustement_item';

$route['select_data/location_code_select'] = 'select_data/location_code_select';

$route['transaction/(:any)'] = 'transaction/approval_module/$1';
$route['adjust'] = 'transaction/adjust';
$route['approve'] = 'transaction/approve';
$route['disapprove'] = 'transaction/approve';
$route['details'] = 'transaction/details';
$route['edit_details'] = 'transaction/edit_details';
$route['transaction_details_approved'] = 'transaction/transaction_details_approved';
$route['login/process'] = 'login/process';
$route['logout'] = 'login/logout';
$route['dashboard'] = 'pages/dashboard';
$route['client'] = 'pages/client';
$route['client_data'] = 'client/data';
$route['client/action/(:any)'] = 'client/action/$1';
$route['home'] = 'pages/home_page';
$route['blank'] = 'pages/blank';
$route['settings'] = 'pages/settings';
$route['update_response'] = 'pages/update_response';
$route['adjustment'] = 'adjustment';
$route['default_controller'] = "login";

//$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */