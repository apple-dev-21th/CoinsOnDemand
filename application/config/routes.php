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
$route['admin/multimedia/(:any)'] = 'admin/multimedia/$1/';
$route['admin/multimedia'] = 'admin/multimedia';
$route['more_themes'] = 'more_themes';
$route['more_themes/(:any)'] = 'more_themes/$1/';
$route['admin/category/(:any)'] = 'admin/category/$1/';
$route['admin/category'] = 'admin/category';
$route['admin/user/(:any)'] = 'admin/user/$1/';
$route['admin/user'] = 'admin/user';
$route['admin/order/(:any)'] = 'admin/order/$1/';
$route['admin/order'] = 'admin/order';
$route['admin/page/(:any)'] = 'admin/page/$1/';
$route['admin/page'] = 'admin/page';
$route['admin/slider/(:any)'] = 'admin/slider/$1/';
$route['admin/slider'] = 'admin/slider';
$route['admin/box/(:any)'] = 'admin/box/$1/';
$route['admin/box'] = 'admin/box';
$route['admin/changepassword/(:any)'] = 'admin/changepassword/$1/';
$route['admin/changepassword'] = 'admin/changepassword';
$route['admin'] = 'admin/login';
$route['admin/(:any)'] = 'admin/login/$1/';
$route['admin/dashboard'] = 'admin/dashboard';
$route['admin/dashboard/(:any)'] = 'admin/dashboard/$1/';
$route['default_controller'] = "home";
$route['personalizedcoin/(:any)'] = 'personalizedcoin/$1/';
$route['checkout'] = 'checkout';
$route['faq'] = 'faq';
$route['contactus'] = 'contactus';
$route['contactus/(:any)'] = 'contactus/$1/';
$route['checkout/(:any)'] = 'checkout/$1/';
$route['checkout_complete'] = 'checkout_complete';
$route['checkout_complete/(:any)'] = 'checkout_complete/$1/';
$route['forgotpassword'] = 'forgotpassword';
$route['forgotpassword/(:any)'] = 'forgotpassword/$1/';
$route['manageaddress'] = 'manageaddress';
$route['manageaddress/(:any)'] = 'manageaddress/$1/';
$route['guest_checkout'] = 'guest_checkout';
$route['guest_checkout/(:any)'] = 'guest_checkout/$1/';
$route['myprofile'] = 'myprofile';
$route['myprofile/(:any)'] = 'myprofile/$1/';
$route['order_detail'] = 'order_detail';
$route['order_detail/(:any)'] = 'order_detail/$1/';
$route['review_order'] = 'review_order';
$route['review_order/(:any)'] = 'review_order/$1/';
$route['select_template/(:any)'] = 'select_template/$1/';
$route['select_template'] = 'select_template';
$route['signin'] = 'signin';
$route['signin/(:any)'] = 'signin/$1/';
$route['signup'] = 'signup';
$route['signup/(:any)'] = 'signup/$1/';
$route['updatecart'] = 'updatecart';
$route['updatecart/(:any)'] = 'updatecart/$1/';
$route['viewmyorder'] = 'viewmyorder';
$route['viewmyorder/(:any)'] = 'viewmyorder/$1/';
$route['forgotpassord'] = 'forgotpassord';
$route['forgotpassord/(:any)'] = 'forgotpassord/$1/';
$route['shipping'] = 'shipping';
$route['shipping/(:any)'] = 'shipping/$1/';
$route['(:any)'] = "home/index/$1";
$route['404_override'] = '';
$route['pricing/(:any)'] = "pricing/index";


/* End of file routes.php */
/* Location: ./application/config/routes.php */