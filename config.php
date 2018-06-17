<?php

if(defined('IS_ADMIN')){

	define('HTTP_SERVER',sprintf('http://%s/admin/',$_SERVER['HTTP_HOST']));
	define('HTTP_CATALOG', sprintf('http://%s/',$_SERVER['HTTP_HOST']));

	define('DIR_APPLICATION', ROOT.'/admin/');
	
	define('DIR_LANGUAGE', ROOT.'/admin/language/');
	//define('DIR_TEMPLATE', '/admin/view/template/');
	define('DIR_TEMPLATE', ROOT.'/admin/view/');
	
	define('DIR_CATALOG', ROOT.'/catalog/');

}else{
	
	define('HTTP_SERVER', sprintf('http://%s/',$_SERVER['HTTP_HOST']));
	define('DIR_APPLICATION', ROOT.'/catalog/');
	define('DIR_LANGUAGE', DIR_APPLICATION.'language/');
	define('DIR_TEMPLATE', DIR_APPLICATION.'view/');

}

define('DIR_IMAGE', ROOT.'/image/');
define('CACHE', ROOT.'/cache/');
define('DIR_SYSTEM', ROOT.'/system/');
define('DIR_DATABASE', DIR_SYSTEM.'database/');
define('DIR_CACHE', DIR_SYSTEM.'cache/');
define('DIR_LOGS', DIR_SYSTEM.'logs/');
define('DIR_CONFIG', DIR_SYSTEM.'config/');

define('DIR_UPLOAD', ROOT.'/upload/');

define('SMARTY_COMPILE', CACHE.'compile/');
define('SMARTY_CACHE', CACHE.'html/');
define('HTML_CACHE', true);

//define('DEFAULT_RESTAURANT_IMAGE', 'no_image.jpg');
//define('GRAY_IMAGE', 'gray.jpg');


define('DB_DRIVER', 'mysql');

define('DB_HOSTNAME', '127.0.0.1');
define('DB_USERNAME', 'sms');
define('DB_PASSWORD', 'sms');
define('DB_DATABASE', 'sms');
define('DB_PREFIX', 'lt_');

