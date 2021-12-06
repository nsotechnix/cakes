<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'authentication';
$route['404_override'] = 'Custom404';
$route['translate_uri_dashes'] = FALSE;
$route['/'] = "authentication/login";
$route['dashboard'] = "dashboard/index";
$route['(:any)'] = "authentication/$1";
