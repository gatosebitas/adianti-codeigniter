<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
$route['default_controller'] = 'welcome';
$route['404_override'] = 'Welcome/error_404';
$route['translate_uri_dashes'] = FALSE;

$route['view/(:num)'] = 'Welcome/view/$1';



$route['login']= 'LoginController/index';
$route['login/error']= 'LoginController/error';
$route['login/autenticacion']= 'LoginController/autenticacion';
$route['listado']= 'LoginController/listado';
$route['login/logout']= 'LoginController/logout';

//$route['cursos/(:any)'] = 'Welcome/view_article/$1';
//$route['blog'] = 'Welcome/view_blog';
//$route['blog/(:any)'] = 'Welcome/view_blog/$1';
//$route['blog/(:any)/(:any)'] = 'Welcome/view_article/$2';




//$route['albumes'] = 'Welcome/indicealbum';
//$route['albumes/(:any)'] = 'Welcome/album/$1';
//$route['albumes/(:any)/(:any)'] = 'Welcome/rootAlbum/$1/$2';
//$route['busqueda'] = 'Welcome/busqueda';
//$route['imagenes/(:any).jpg'] = 'Welcome/imagenes/$1';
//$route['c/(:any)'] = 'Welcome/cont/$1';
