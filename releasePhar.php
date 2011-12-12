<?php
$st = microtime(TRUE);
if(!isset($argv[1])){
	displayErr("Invalid arg.\n");
}
if($argv[1]=='-h' || $argv[1]=='-H' || $argv[1]=='--H' || $argv[1]=='--h' || $argv[1]=='-help' || $argv[1]=='--help'){
	echo getHelpMsg();
	exit();
}
$argCount = count($argv);
for($i=0;$i<$argCount;$i++){
	if($argv[$i]=='-p' || $argv[$i]=='-sdkPath'){
		if(isset($argv[$i+1])){
			$root_dir=$argv[$i+1];
			if(!file_exists($root_dir)){
				displayErr("the php sdk path doesn't exists!\n", FALSE);
			}
		}else{
			displayErr("Please specify the path of PHP SDK\n", FALSE);
		}
	}
}

define('FRAMEWORK_DIR', $root_dir.'/framework');
//create framework directory
if(!file_exists(FRAMEWORK_DIR)){
	@exec('mkdir '.FRAMEWORK_DIR);
	@exec('chmod ugo+r '.FRAMEWORK_DIR);
}

//解压phar包
$phar = new Phar($root_dir.'/xingcloudphp.phar');
$phar->extractTo(FRAMEWORK_DIR, null, true); // extract all files

$et = microtime(TRUE);

//echo 'build phar file:'.($et-$st);
//echo "\n\n";

function displayErr($msg, $echoHelp=TRUE){
	echo $msg;
	if($echoHelp){
		echo getHelpMsg();
	}
	die();
}
function getHelpMsg(){
	$str = "<Usage>\n";
	$str .= "php releasePhar.php [-options]\n";
	$str .= "where options include:\n";
	$str .= "    -p, -sdkPath:   PHP SDK path\n";
	$str .= "Usage Sample:\n";
	$str .= "    php releasePhar.php -p \"/usr/sdk/php\"\n";
	return $str;
}
?>