<?php
require_once dirname(dirname(dirname(dirname(__FILE__)))) . "/index.php";

import('app.XAppFactory');
$app = XAppFactory :: getApp();
$appInfo = $app->getAppInfo();
echo "instanceid:" . $appInfo['appId'];
echo '<br>';
$appConfig = $app->getAppConfig();
$persistence = $appConfig->get('persistence');
$host = $persistence['mysql']['host'];
echo "host:" . $host;
?>
