<?php
//environment must be one of them: dev, prod. dev is default.
if(!defined("__DEV__")){
	define("__DEV__", true);
}
//MVC mode is turned off by default.
if(!defined("__MVC__")){
	define("__MVC__", false);
}

define("XINGCLOUD_GAMEENGINE_DIR", dirname(__FILE__));

require XINGCLOUD_GAMEENGINE_DIR."/framework/framework.php";

$xingcloudRequestStartTime = microtime(true);
XingCloudApp::singleton()->start(FALSE);
?>