<?php
require_once dirname(dirname(dirname(dirname(__FILE__)))) . "/app/app.php";
echo 'mysql_host:' . xingcloud_get('mysql_host');
echo '<br>';
echo 'mysql_port:' . xingcloud_get('mysql_port');
echo '<br>';
echo 'mysql_user:' . xingcloud_get('mysql_user');
echo '<br>';
echo 'mysql_pass:' . xingcloud_get('mysql_pass');
echo '<br>';
echo 'mysql_db:' . xingcloud_get('mysql_db');
echo '<br>';
echo 'memcache_host:' . xingcloud_get('memcache_host');
echo '<br>';
echo 'memcache_host is null:' . is_null(xingcloud_get('memcache_host'));
echo '<br>';
echo 'memcache_port:' . xingcloud_get('memcache_port');
echo '<br>';
echo 'memcache_port is null:' . is_null(xingcloud_get('memcache_port'));
echo '<br>';
echo 'isCloud:' . XRuntime :: singleton()->isCloud();
echo '<br>';
echo 'isCloud is null:' . is_null(XRuntime :: singleton()->isCloud());
echo '<br>';

$mysql_host=xingcloud_get("mysql_host");

$mysql_port=xingcloud_get("mysql_port");

$mysql_user=xingcloud_get("mysql_user");

$mysql_pass=xingcloud_get("mysql_pass");

$mysql_db=xingcloud_get("mysql_db");

$conn=mysql_connect($mysql_host.':'.$mysql_port,$mysql_user,$mysql_pass);

echo 'database:' . mysql_select_db($mysql_db);

mysql_close($conn);
?>
