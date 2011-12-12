<?php
$xingcloudRequestStartTime = microtime(true);
//environment must be one of them: dev, prod. dev is default.
define("__DEV__", true);
//MVC mode is turned off by default.
define("__MVC__", false);
//include framework code from PHAR file, default value is false
define("__PHAR__", true);

define("XINGCLOUD_DIR", dirname(__FILE__));

if(defined("__PHAR__") && __PHAR__ && is_file(XINGCLOUD_DIR.'/xingcloudphp.phar')){
	require 'phar://'.XINGCLOUD_DIR.'/xingcloudphp.phar/framework.php';
}else{
	require XINGCLOUD_DIR."/framework/framework.php";
}

XingCloudApp::singleton()->start();
?>