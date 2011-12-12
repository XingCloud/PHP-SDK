<?php
$st = microtime(TRUE);
ini_set('max_execution_time', 0);
if(!isset($argv[1])){
	displayErr("Invalid arg.");
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
				displayErr("the php sdk path doesn't exists!", FALSE);
			}
		}else{
			displayErr("Please specify the path of PHP SDK", FALSE);
		}
	}
	if($argv[$i]=='-skey' || $argv[$i]=='-secretKey'){
		if(isset($argv[$i+1])){
			$secretKey=$argv[$i+1];
		}else{
			displayErr("Please specify the secretKey", FALSE);
		}
	}
	if($argv[$i]=='-ckey' || $argv[$i]=='-customerKey'){
		if(isset($argv[$i+1])){
			$customerKey=$argv[$i+1];
		}else{
			displayErr("Please specify the customerKey", FALSE);
		}
	}
	if($argv[$i]=='-Dmodules'){
		if(isset($argv[$i+1])){
			$modules=$argv[$i+1];
		}else{
			displayErr("Please specify the required modules", FALSE);
		}
	}
}
//在temp目录下合并代码并打包
define('TEMP_DIR', $root_dir.'/temp');
define('CORE_SDK_DIR', $root_dir.'/core_sdk');
define('GEN_CODE_DIR', $root_dir.'/gen_code');
define('RESOURCE_DIR', dirname($root_dir).'/resource');
define('TEMP_CORE_SDK_DIR', $root_dir.'/temp/core_sdk');

if(file_exists(TEMP_DIR)){
	@exec('\rm -rf '.TEMP_DIR);
}
@exec('mkdir '.TEMP_DIR);
@exec('\cp -R '.CORE_SDK_DIR.' '.TEMP_DIR);

//模块化
if(isset($modules)){
	$modules = explode(',', $modules);
	$serviceDir = TEMP_CORE_SDK_DIR.'/framework/service';;
	if(!empty($modules)){
		@exec('rm '.$serviceDir.'/* -R');
		foreach ($modules as $module){
			if($module=='Audit Change'){
				$moduleName = 'change';
			}else{
				$moduleName = $module;
			}
			$moduleName = strtolower($moduleName);
			$moduleDir = CORE_SDK_DIR.'/framework/service/'.$moduleName;
			@exec('cp '.$moduleDir.' '.$serviceDir.' -R');
			//更新sdk-description.xml
			try {
				chooseModule(ucfirst($module));
			}catch (Exception $e){
				displayErr('modify sdk-description failed. '.$e->getMessage(), false);
			}
		}
	}
}

//从gen_code目录中合并代码到framework
//拷贝Audit Change代码
$auditChangePath = GEN_CODE_DIR.'/auditchange/src/game/service/change';
$frameworkAuditChangePath = TEMP_CORE_SDK_DIR.'/framework/service/change';
if(file_exists($auditChangePath)){
	@exec('cp '.$auditChangePath.'/* '.$frameworkAuditChangePath.' -R');
}
//拷贝validator代码
$validatorPath = GEN_CODE_DIR.'/auditchange/src/game/service/change/validator';
$frameworkValidatorPath = CORE_SDK_DIR.'/game/service/change/validator';
if(file_exists($validatorPath)){
	@exec('cp '.$validatorPath.'/* '.$frameworkValidatorPath.' -uR');
}
//拷贝resource目录
$resourcePath = RESOURCE_DIR;
$sdkResourcePath = CORE_SDK_DIR.'/resource';
if(file_exists($resourcePath)){
	@exec('cp '.$resourcePath.'/* '.$sdkResourcePath.' -R');
}
//拷贝user代码
$userPath = GEN_CODE_DIR.'/itemmodeling/src/game/service/user';
$frameworkUserPath = TEMP_CORE_SDK_DIR.'/framework/service/user/lib';
if(file_exists($userPath)){
	@exec('cp '.$userPath.'/* '.$frameworkUserPath.' -R');
}
//拷贝 OwnedItem代码
$itemPath = GEN_CODE_DIR.'/itemmodeling/src/game/service/item';
$frameworkItemPath = TEMP_CORE_SDK_DIR.'/framework/service/user/item';
if(file_exists($itemPath)){
	@exec('cp '.$itemPath.'/* '.$frameworkItemPath.' -R');
}
//拷贝ItemSpec代码
$itemPath = GEN_CODE_DIR.'/itemspecmodeling/src/game/service/itemspec';
$frameworkItemPath = TEMP_CORE_SDK_DIR.'/framework/service/itemspec';
if(file_exists($itemPath)){
	@exec('cp '.$itemPath.'/* '.$frameworkItemPath.' -R');
}

//替换新的consumer_key和secret_key
$authConfigs[] = TEMP_CORE_SDK_DIR.'/framework/config/authkey.php';
foreach ($authConfigs as $authConfig){
	if(file_exists($authConfig)){
		if(isset($customerKey) && !empty($customerKey)){
			replaceKeyInFile("'consumer_key'", $customerKey, $authConfig, 'oauth');
			replaceKeyInFile("'consumer_key'", $customerKey, $authConfig, 'admin');
		}
		if(isset($secretKey) && !empty($secretKey)){
			replaceKeyInFile("'secret_key'", $secretKey, $authConfig, 'oauth');
			replaceKeyInFile("'secret_key'", $secretKey, $authConfig, 'admin');
		}
	}else{
		displayErr('auth config file doesn\'t exist', false);
	}
}

//移除phar包
$pharFile = $root_dir.'/xingcloudphp.phar';
if(file_exists($pharFile)){
	@exec('\rm -f '.$pharFile);
}
//生成phar包
try {
    $phar = new Phar($pharFile, 0, 'xingcloudphp.phar');
} catch (UnexpectedValueException $e) {
	displayErr('Could not open xingcloudphp.phar. '.$e->getMessage(), false);
} catch (BadMethodCallException $e) {
	displayErr('BadMethodCallException when create Phar instance. '.$e->getMessage(), false);
} catch (Exception $e) {
	displayErr('error occurred when create Phar instance. '.$e->getMessage(), false);
}
try {
    $phar->buildFromDirectory(TEMP_CORE_SDK_DIR.'/framework');
} catch (BadMethodCallException $e) {
	displayErr('BadMethodCallException when build phar file. '.$e->getMessage(), false);
} catch (Exception $e) {
	displayErr('error occurred when build phar file from xingcloud framework. '.$e->getMessage(), false);
}

//生成PHPDOC
$codeDir = TEMP_CORE_SDK_DIR;
$docDir = $root_dir.'/doc';
if(!file_exists($docDir)){
	@exec('mkdir '.$docDir);
}
@exec('\rm -rf '.$docDir.'/*');
@exec('phpdoc -q -s on -d '.$codeDir.' -t '.$docDir);

//生成service doc
//生成PHPDOC
$serviceDir = TEMP_CORE_SDK_DIR.'/framework/service';
$serviceDocDir = $root_dir.'/service_doc';
if(!file_exists($serviceDocDir)){
	@exec('mkdir '.$serviceDocDir);
}
@exec('\rm -rf '.$serviceDocDir.'/*');
@exec('phpdoc -q -s on -d '.$serviceDir.' -t '.$serviceDocDir);

@exec('\rm -rf '.TEMP_DIR);

$et = microtime(TRUE);

//echo 'build phar file:'.($et-$st);
//echo "\n\n";

function displayErr($msg, $echoHelp=TRUE){
	$msg = 'PHP_Build_Fail: '.$msg."\n";
	echo $msg;
	if($echoHelp){
		echo getHelpMsg();
	}
	die();
}
function getHelpMsg(){
	$str = "<Usage>\n";
	$str .= "php createPhar.php [-options]\n";
	$str .= "where options include:\n";
	$str .= "    -p, -sdkPath:   PHP SDK path\n";
	$str .= "Usage Sample:\n";
	$str .= "    php createPhar.php -p \"/usr/sdk/php\"\n";
	return $str;
}
function replaceKeyInFile($oldKeyName, $newKeyValue, $fileName, $type='oauth'){
	$file = file_get_contents($fileName);
	$nodePos = strpos($file, $type);
	$keyPos = strpos($file, $oldKeyName, $nodePos);
	replaceKey($keyPos, $file, $newKeyValue);
	file_put_contents($fileName, $file);
}
function replaceKey($startPos, &$file, $newKeyValue){
	$pos = strpos($file, '=>', $startPos);
	$keyStartPos = strpos($file, '\'', $pos);
	$keyStartPos += 1;
	$substr = substr($file, $keyStartPos);
	$keyStopPos = strpos($file, '\'', $keyStartPos);
	$file = substr_replace($file, $newKeyValue, $keyStartPos, $keyStopPos-$keyStartPos);
}
function chooseModule($module){
	$filename = TEMP_CORE_SDK_DIR.'/framework/resource/sdk-description.xml';
	$dom = simplexml_load_file($filename);
	$node = $dom->xpath("/sdk-description/version/modules/module[@name='$module']");
	$node = $node[0];
	$node['choose'] = "true";
	$dom->asXML($filename);
}
?>