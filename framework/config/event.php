<?php
//事件监听配置文件
return array(
	//添加事件监听器，添加规则为：监听器类名=>监听器完整路径
	'listeners' => array(
		'XLoggerListener' => 'module.util.logger.XLoggerListener',
		'XStatisticsListener' => 'module.util.statistics.XStatisticsListener',
		'XContextCloseListener' => 'module.event.context.XContextCloseListener',
	),
);
?>