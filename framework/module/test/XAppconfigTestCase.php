<?php
require_once dirname(dirname(dirname(dirname(__FILE__)))) . "/index.php";
import('app.XRuntime');

$runtime = XRuntime :: singleton();
$appconfig = $runtime->getAppConfig();

$persistence = $appconfig->get('persistence');
$host = $persistence['mysql']['host'];
echo $host;
echo '<br>';
$test = null;
if (isset ($persistence['mysql']['ho'])) {
	$test = $persistence['mysql']['ho'];
}
echo $test;
echo '<br>';

$config = $appconfig->getConfig();
echo $config['mysql_host'];
echo '<br>';
echo $config['mysql_port'];
?>
