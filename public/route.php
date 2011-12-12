<?php
if(preg_match('/^(\/rest|\/status|\/amf|\/discovery|\/admin|\/rpc|\/file)/i', $_SERVER["REQUEST_URI"])){
    include_once "./index.php";
}else{
    return false;
}
?>