<?php
/**
 * framework.php
 * 
 * #en framework constants; require core files
 * #zh 定义框架常量，载入框架核心文件
 * @author Tianwei
 */
define("__DS__", DIRECTORY_SEPARATOR);
define("XINGCLOUD_FRAMEWORK_DIR", dirname(__FILE__));
define("XINGCLOUD_CONFIG_DIR", XINGCLOUD_FRAMEWORK_DIR.'/config');
define("XINGCLOUD_SERVICE_DIR", XINGCLOUD_FRAMEWORK_DIR.'/service');
define("XINGCLOUD_MODULE_DIR", XINGCLOUD_FRAMEWORK_DIR.'/module');
define("XINGCLOUD_PLUGIN_DIR", XINGCLOUD_FRAMEWORK_DIR.'/plugin');
define("XINGCLOUD_UTIL_DIR", XINGCLOUD_DIR.'/util');

define("XINGCLOUD_INNER_RESOURCE_DIR", XINGCLOUD_FRAMEWORK_DIR.__DS__.'resource');
define("XINGCLOUD_RESOURCE_DIR", XINGCLOUD_DIR.__DS__.'resource');

define("GAME_DIR", XINGCLOUD_DIR.__DS__.'game');
define("GAME_CONFIG_DIR", GAME_DIR.__DS__.'config');
define("GAME_SERVICE_DIR", GAME_DIR.__DS__.'service');
define("GAME_MVC_DIR", GAME_DIR.__DS__.'mvc');
define("GAME_LOG_DIR", GAME_DIR.__DS__.'logs');
define("GAME_TMP_DIR", GAME_DIR.__DS__.'tmp');

define("AMFPHP_BASE", XINGCLOUD_PLUGIN_DIR.'/amfphp/');

$GLOBALS['THRIFT_ROOT'] = XINGCLOUD_PLUGIN_DIR.'/thrift';

require XINGCLOUD_FRAMEWORK_DIR . __DS__. "corefunctions.php";
require XINGCLOUD_UTIL_DIR.__DS__."util.php";
require XINGCLOUD_FRAMEWORK_DIR . __DS__. "XingCloudApp.php";
?>