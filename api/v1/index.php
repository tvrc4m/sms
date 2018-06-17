<?php

header('Content-type:text/html;charset=utf-8');

// error_reporting(E_ALL);
// error_reporting(E_ALL & ~E_NOTICE);
// ini_set('display_errors','On');
date_default_timezone_set('Asia/Shanghai');

define("ROOT",dirname(__FILE__));

include_once(ROOT.'/core/config.php');
include_once(CORE.'code.inc.php');

ini_set('session.cookie_domain',COOKIE_DOMAIN);

#session_save_path(ROOT.'/session');

session_start();

include_once(CORE.'function.php');
include_once(CORE.'common.php');
include_once(CORE.'db.class.php');
include_once(CORE.'model.class.php');
include_once(CORE.'view.class.php');
include_once(CORE.'medium.class.php');
include_once(CORE.'action.class.php');


!isset($_REQUEST['app']) && $_REQUEST['app']='index';

$app=$_REQUEST['app'];

$method=isset($_REQUEST['act'])?$_REQUEST['act']:'index';

$appFile=ACTION.strtolower($app).'.action.php';

!file_exists($appFile) && exit('指定文件不存在');

include_once($appFile);

$className=ucfirst($app).'Action';

$appInstance=new $className;

!method_exists($appInstance,$method) && exit;

try{
	
	$appInstance->$method();

}
catch(Exception $e){

	exit;
	
}
