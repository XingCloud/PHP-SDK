<?php
/**
 * cache模块入口
 * @package cache
 */
defined('CACHE_DIR') or define("CACHE_DIR", dirname(__FILE__));
defined('CACHE_MODULE_DIR') or define("CACHE_MODULE_DIR", CACHE_DIR.'/module');
defined('CACHE_CONFIG_DIR') or define("CACHE_CONFIG_DIR", CACHE_DIR.'/config');
require_once dirname(CACHE_DIR).'/util/util.php';
?>