<?php

$msgId = $_SERVER['argv'][1];
$nb_arg = $_SERVER['argc'] - 1;

$msgExtName = '';

if($nb_arg >= 2)
	$msgExtName = base64_decode($_SERVER['argv'][2]);
$msgExplain = '';
if($nb_arg >= 3)
	$msgExplain = base64_decode($_SERVER['argv'][3]);

if(is_numeric($msgId) && $msgId > 0 && $msgId < 14) {
	$message = array(
	1 => "This PHP version ".$msgExtName." doesn't seem to be compatible with your actual Apache Version.

".$msgExplain,
	2 => "This Apache version ".$msgExtName." doesn't seem to be compatible with your actual PHP Version.

".$msgExplain,
	3 => "The '".$msgExtName.".dll' extension file exists but there is no 'extension=".$msgExtName.".dll' line in php.ini.",
	4 => "The line 'extension=".$msgExtName.".dll' exists in php.ini file but there is no ".$msgExtName.".dll' file in ext/ directory.",
	5 => "The '".$msgExtName."' extension cannot be loaded by 'extension=".$msgExtName.".dll' in php.ini. Must be loaded by 'zend_extension='.",
	6 => "The value of '".$msgExtName."' is neither 'on' nor 'off' and cannot be switched.",
	7 => "There is 'LoadModule ".$msgExtName." modules/mod_".$msgExtName.".so' line in httpd.conf file
   but there no 'mod_".$msgExtName.".so' file in apachex.y.z/modules/ directory.",
  8 => "There is 'mod_".$msgExtName.".so' file in apachex.y.z/modules/ directory
   but there is no 'LoadModule ".$msgExtName." modules/mod_".$msgExtName.".so' line in httpd.conf file",
  9 => "The ServerName '".$msgExtName."' has syntax error.

 Characters accepted [a-zA-Z0-9.-]
 Only letter or number at the beginning and at the end
 . or - characters neither at the beginning nor at the end
 . or - characters not followed by . or -",
 10 => "States of services:\n\n".$msgExtName,
 11 => "There is an error.\n".$msgExtName,
 12 => "The module ".$msgExtName." must not be disables.",
 13 => "In ".$msgExtName." file,
 MySQL Server has not the same name as MySQL service: ".$msgExplain."
 
 The content of the file (about line 25) must be:
 
 # The MySQL server
 [".$msgExplain."]
 ",
	);
	function message_add(&$array) {
	$array = "Sorry,

".$array."

Switch cancelled

Press ENTER to continue...
";
}
array_walk($message, 'message_add');

echo $message[$msgId];
}
elseif(is_string($msgId)) {
	if($msgId == "stateservices") {
		$message['stateservices'] = "State of services:\n\n";
		require 'config.inc.php';
		$services = array($c_apacheService,$c_mysqlService);
		foreach($services as $value) {
			$message['stateservices'] .= "        The service ".$value;
			$command = 'sc query '.$value.' | find "STATE"';
			$output = `$command`;
			if(strpos($output, "RUNNING") !== false)
				$message['stateservices'] .= " is started\n\n";
			else
				$message['stateservices'] .= " is NOT started\n\n";
		}
	echo $message['stateservices'];
	}
	elseif($msgId == "compilerversions") {
		echo "It may take a while ...";
		$phpCompiler = array();
		$apacheCompiler = array();
		$apacheVersion = array();
		$phpApacheDll = array();
		$phpErrorMsg = array();
		require_once 'config.inc.php';
		require_once 'wampserver.lib.php';
		$message['compilerversions'] = "Compiler Visual C++ versions used:\n\n";
		$apacheVersionList = listDir($c_apacheVersionDir,'checkApacheConf');
		$phpVersionList = listDir($c_phpVersionDir,'checkPhpConf');

		// Apache versions
		foreach($apacheVersionList as $oneApache) {
    	$oneApacheVersion = str_ireplace('apache','',$oneApache);
    	$pos = strrpos($oneApacheVersion,'.');
    	$apacheVersion[] = substr($oneApacheVersion,0,$pos);
    	$command = 'start /b /wait '.$c_apacheVersionDir.'/apache'.$oneApacheVersion.'/'.$wampConf['apacheExeDir'].'/'.$wampConf['apacheExeFile'].' -v | find "built"';
			$output = exec($command, $result);
			$apacheCompiler[$oneApacheVersion] = $output;
			echo ".";
    }
    
		// PHP versions
		foreach($phpVersionList as $onePhp) {
			$onePhpVersion = str_ireplace('php','',$onePhp);
			$command = 'start /b /wait '.$c_phpVersionDir.'/php'.$onePhpVersion.'/'.$wampConf['phpCliFile'].' -i | find "Compiler"';
			$output = exec($command, $result);
			$phpCompiler[$onePhpVersion] = $output;
			//Search compatibility with Apache
			unset($phpConf);
		  include $c_phpVersionDir.'/php'.$onePhpVersion.'/'.$wampBinConfFiles;
			foreach($apacheVersion as $value) {
				if(!empty($phpConf['apache'][$value]['LoadModuleFile']) && file_exists($c_phpVersionDir.'/php'.$onePhpVersion.'/'.$phpConf['apache'][$value]['LoadModuleFile']))
					$phpApacheDll[$onePhpVersion][$value] = true;
				else {
				$phpApacheDll[$onePhpVersion][$value] = false;
				if(empty($phpConf['apache'][$value]['LoadModuleFile']))
					$phpErrorMsg[$onePhpVersion][$value] = "\$phpConf['apache']['".$value."']['LoadModuleFile'] does not exists or is empty in ".$c_phpVersionDir.'/php'.$onePhpVersion.'/'.$wampBinConfFiles;
				elseif(!file_exists($c_phpVersionDir.'/php'.$onePhpVersion.'/'.$phpConf['apache'][$value]['LoadModuleFile']))
					$phpErrorMsg[$onePhpVersion][$value] = $c_phpVersionDir.'/php'.$onePhpVersion.'/'.$phpConf['apache'][$value]['LoadModuleFile']." file does not exists.";
				}
			}
		echo ".";
		}
		
    foreach($phpCompiler as $key=>$value) {
    	$message['compilerversions'] .= "PHP ".$key." ".$value."\n";
    	foreach($apacheVersion as $apache) {
    		if($phpApacheDll[$key][$apache])
    			$message['compilerversions'] .= "\tis compatible with Apache ".$apache."\n";
    		else {
    			$message['compilerversions'] .= "\tis NOT COMPATIBLE with Apache ".$apache."\n";
    			$message['compilerversions'] .= "\t".$phpErrorMsg[$key][$apache]."\n";
    		}
    	}
    	$message['compilerversions'] .= "\n";
		echo ".";
    }
		$message['compilerversions'] .= "\n\n";
    foreach($apacheCompiler as $key=>$value)
    	$message['compilerversions'] .= "Apache ".$key." ".$value."\n"; 
		echo "\n\n".$message['compilerversions'];
	}
	echo "\nPress ENTER to continue...";
}

trim(fgets(STDIN));

?>