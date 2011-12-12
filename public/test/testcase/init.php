<?php
define("__DEV__", true);
//include framework code from PHAR file, default value is false
define("__PHAR__", true);

define("XINGCLOUD_DIR", dirname(dirname(dirname(dirname(__FILE__)))));

if(defined("__PHAR__") && __PHAR__ && is_file(XINGCLOUD_DIR.'/xingcloudphp.phar')){
	require 'phar://'.XINGCLOUD_DIR.'/xingcloudphp.phar/framework.php';
}else{
	require XINGCLOUD_DIR."/framework/framework.php";
}


XingCloudApp::singleton()->start(false);
define("XINGCLOUD_TESTCASE_DIR", XINGCLOUD_DIR.__DS__.'public'.__DS__.'test'.__DS__.'testcase');
//import_all();
import_dir(XINGCLOUD_SERVICE_DIR);
import_dir(GAME_DIR);
?>