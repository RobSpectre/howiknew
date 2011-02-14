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
| 	example.com/class/method/id/
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
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['scaffolding_trigger'] = 'scaffolding';
|
| This route lets you set a "secret" word that will trigger the
| scaffolding feature for added security. Note: Scaffolding must be
| enabled in the controller in which you intend to use it.   The reserved 
| routes must come before any wildcard or regular expression routes.
|
*/


// Main site
$route['default_controller'] = "vignettes";
$route['page'] = "vignettes";
$route['page/:num'] = "vignettes";
$route['id/:num'] = "vignettes/id";
$route['rss'] = "vignettes/rss";
$route['random'] = "vignettes/random";
$route['mostloved'] = "vignettes/mostloved";
$route['tag/:num'] = "vignettes/tag";

// Static content
$route['about'] = "vignettes/about";
$route['questions'] = "vignettes/questions";
$route['privacy'] = "vignettes/privacy";
$route['contact'] = "vignettes/contact";

// Moderation interface
$route['mod'] = "moderate";
$route['mod/:num'] = "moderate";
$route['mod/login'] = "moderate/login";
$route['mod/logout'] = "moderate/logout";
$route['mod/edit'] = "moderate/edit";
$route['mod/edit/:num'] = "moderate/edit";
$route['mod/rejects'] = "moderate/rejects";
$route['mod/rejects/:num'] = "moderate/rejects";
$route['mod/access'] = "moderate/access";
$route['mod/approveVignette'] = "moderate/approveVignette";
$route['mod/rejectVignette'] = "moderate/rejectVignette";
$route['mod/editVignette'] = "moderate/editVignette";

// API
$route['heart'] = 'heart';
$route['tag'] = 'tag';
$route['sms/:num'] = 'sms';
$route['api'] = 'api';
$route['api/xml'] = 'api';
$route['api/json'] = 'api';
$route['api/:num'] = 'api/id';
$route['api/:num/:any'] = 'api/id';
$route['scaffolding_trigger'] = "scaffoldthatshizmofointhepooper";

/* End of file routes.php */
/* Location: ./system/application/config/routes.php */
