<?php
/**
 * 缓存信息配置文件
 * @package cache
 */
return array(
//	'apc' => array(
//		'type' => 'apc',
//	),
	'memcache' => array(
		'type' => 'memcache',
		'servers' => array(
			array(
				'host' => '127.0.0.1',
				'port' => 11211,	
			),
		),
	),
);
?>