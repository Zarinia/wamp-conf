<?php

$msgId = $_SERVER['argv'][1];
$nb_arg = $_SERVER['argc'] - 1;

$msgExtName = '';

if($nb_arg >= 2)
	$msgExtName = base64_decode($_SERVER['argv'][2]);
$msgExplain = '';
if($nb_arg >= 3)
	$msgExplain = base64_decode($_SERVER['argv'][3]);

if(is_numeric($msgId) && $msgId > 0 && $msgId < 16) {
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
 14 => "To have the VirtualHost, the line:\n\n#Include conf/extra/httpd-vhosts.conf\n\nmust be uncommented in httpd.conf file",
 15 => "The file:\n\n".$msgExtName."\n\ndoes not exists.",
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
		$services_OK = true;
		$message['stateservices'] = "State of services:\n\n";
		require 'config.inc.php';
		$services = array($c_apacheService,$c_mysqlService, 'dnscache');
		foreach($services as $value) {
			$message['stateservices'] .= "        The service '".$value."'";
			$command = 'sc query '.$value.' | find "STATE"';
			$output = `$command`;
			if(strpos($output, "RUNNING") !== false)
				$message['stateservices'] .= " is started\n\n";
			else {
				$message['stateservices'] .= " is NOT started\n\n";
				$services_OK = false;
			}
		}
		if(!$services_OK) {
			$message['stateservices'] .= "WampServer (Apache, PHP and MySQL) will not function properly if any service\n";
			foreach($services as $value) {
				$message['stateservices'] .= "'".$value."'\n";
			}		
			$message['stateservices'] .= " is not started.\n\n";
		}
		else
			$message['stateservices'] .= "\t\t\tall services are started - it is OK\n";
	echo $message['stateservices'];
	}
	elseif($msgId == "compilerversions") {
		echo "It may take a while ...";
		$phpCompiler = array();
		$apacheCompiler = array();
		$apacheVersion = array();
		$phpApacheDll = array();
		$phpErrorMsg = array();
		$mysqlVersion = array();
		$v32 = array();
		$v64 = array();
		$nb_v = 0;
		require_once 'config.inc.php';
		require_once 'wampserver.lib.php';
		$message['compilerversions'] = "Compiler Visual C++ versions used:\n\n";
		$apacheVersionList = listDir($c_apacheVersionDir,'checkApacheConf');
		$phpVersionList = listDir($c_phpVersionDir,'checkPhpConf');
		$mysqlVersionList = listDir($c_mysqlVersionDir,'checkMysqlConf');

		// Apache versions
		foreach($apacheVersionList as $oneApache) {
    	$oneApacheVersion = str_ireplace('apache','',$oneApache);
    	$pos = strrpos($oneApacheVersion,'.');
    	$apacheVersion[] = substr($oneApacheVersion,0,$pos);
    	$command = 'start /b /wait '.$c_apacheVersionDir.'/apache'.$oneApacheVersion.'/'.$wampConf['apacheExeDir'].'/'.$wampConf['apacheExeFile'].' -v | find "built"';
			$output_1 = exec($command, $result);
			$command = 'start /b /wait '.$c_apacheVersionDir.'/apache'.$oneApacheVersion.'/'.$wampConf['apacheExeDir'].'/'.$wampConf['apacheExeFile'].' -V | find "Architecture"';
			$output_2 = exec($command, $result);
			if(strpos($output_2, "32-bit") !== false)
				$v32[] = $oneApache ;
			elseif(strpos($output_2, "64-bit") !== false)
				$v64[] = $oneApache;
			$apacheCompiler[$oneApacheVersion] = $output_1."\n\t".$output_2;
			$nb_v++;
			echo ".";
    }
    
		// PHP versions
		foreach($phpVersionList as $onePhp) {
			$onePhpVersion = str_ireplace('php','',$onePhp);
			$command = 'start /b /wait '.$c_phpVersionDir.'/php'.$onePhpVersion.'/'.$wampConf['phpCliFile'].' -i | find "Compiler"';
			$output_1 = exec($command, $result);
			$command = 'start /b /wait '.$c_phpVersionDir.'/php'.$onePhpVersion.'/'.$wampConf['phpCliFile'].' -i | find "Architecture"';
			$output_2 = exec($command, $result);
			if(strpos($output_2, "x86") !== false)
				$v32[] = $onePhp;
			elseif(strpos($output_2, "x64") !== false)
				$v64[] = $onePhp;
			$phpCompiler[$onePhpVersion] = $output_1."\n\t".$output_2;
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
			$nb_v++;
			echo ".";
		}
		
		// MySQL versions
		foreach($mysqlVersionList as $oneMysql) {
			$oneMysqlVersion = str_ireplace('mysql','',$oneMysql);
    	$command = 'start /b /wait '.$c_mysqlVersionDir.'/mysql'.$oneMysqlVersion.'/'.$wampConf['mysqlExeDir'].'/'.$wampConf['mysqlExeFile'].' -V';
			$output = exec($command, $result);
			$pos = strrpos($output,'Ver ');
			$output = substr($output,$pos);
			if(strpos($output, "x86 ") !== false)
				$v32[] = $oneMysql;
			elseif(strpos($output, "x86_64") !== false)
				$v64[] = $oneMysql;
			$mysqlVersion[$oneMysqlVersion] = $output;
			$nb_v++;
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
    
    foreach($mysqlVersion as $key=>$value) {
    	$message['compilerversions'] .= "MySQL ".$value."\n";
    }
    
		$message['compilerversions'] .= "\n\n";
    foreach($apacheCompiler as $key=>$value)
    	$message['compilerversions'] .= "Apache ".$key." ".$value."\n";
		$nb_v32 = count($v32);
		$nb_v64 = count($v64);
    if(($nb_v32 > 0 && $nb_v64 != 0) || ($nb_v64 > 0 && $nb_v32 !=0)) {
    	$message['compilerversions'] .= "\n\t\tWARNING - WARNING - WARNING\nIt is IMPERATIVE that all versions are the SAME TYPE\nThere are:\n\t".$nb_v32." version(s) for x86 (32-bit)\n\t".$nb_v64." version(s) for x64 (64-bit)\n";
    	$message['compilerversions'] .= "32 bit versions are\n";
    	foreach($v32 as $value)
    		$message['compilerversions'] .= "\t".$value."\n";
    	$message['compilerversions'] .= "64 bit versions are\n";
    	foreach($v64 as $value)
    		$message['compilerversions'] .= "\t".$value."\n";
    }
		echo "\n\n".$message['compilerversions'];
	}
	elseif($msgId == "vhostconfig") {
		$message['apachevhosts'] = "VirtualHost configuration:\n\n";
		require_once 'config.inc.php';
		$myhttpd_contents = file_get_contents($c_apacheConfFile);
		if(preg_match("~^[ \t]*#[ \t]*Include[ \t]*conf/extra/httpd-vhosts.conf.*$~m",$myhttpd_contents) > 0) {
			$message['apachevhosts'] .= "*** WARNING: It is impossible to get VirtualHost\n#Include conf/extra/httpd-vhosts.conf\nline is commented in httpd.conf\n";
		}
		else {
			$c_vhostConfFile = $c_apacheVersionDir.'/apache'.$wampConf['apacheVersion'].'/'.$wampConf['apacheConfDir'].'/extra/httpd-vhosts.conf';
			if(!file_exists($c_vhostConfFile)) {
				$message['apachevhosts'] .= "*** WARNING: The file\n".$c_vhostConfFile."\ndoes not exist\n";
			}
			else {
				$myVhostsContents = file_get_contents($c_vhostConfFile);
				
				$default_server = false;
				$virtual_host = false;
				$default_localhost = false;
      	
				$command = 'start /b /wait '.$c_apacheExe.'  -t -D DUMP_VHOSTS';
				ob_start();
				passthru($command);
				$output = ob_get_contents();
				ob_end_clean();
				if(!empty($output)) {
					if(preg_match("~^[ \t]*default server (.*) \(.*\)$~m",$output, $matches) > 0 ) {
						$message['apachevhosts'] .= "\tDefault server: ".$matches[1]."\n";
						$default_server = true;
						if($matches[1] == "localhost")
							$default_localhost = true;
					}
					if($nb_vhost = preg_match_all("~^.*namevhost (.*) \(.*\)$~m",$output, $matches) > 0 ) {
						$virtual_host = true;
						foreach($matches[1] as $value) {
							$message['apachevhosts'] .= "Virtual Host: ".$value."\n";
						}
					}
					if(!$default_server && !$virtual_host) {
						if(preg_match("~^(?:\*|[0-9\.]*):[0-9]{2,5}[ \t]*(.*) \(.*\)$~m",$output, $matches) > 0) {
							$message['apachevhosts'] .= "\tDefault server: ".$matches[1]."\n\n";
							$default_server = true;
							if($matches[1] == "localhost")
								$default_localhost = true;
						}
					}
					if(!$default_localhost)
						$message['apachevhosts'] .= "*** WARNING: The name of the default server must be 'localhost'\n\n";
					if(!$default_server)
						$message['apachevhosts'] .= "*** WARNING: There is no default server\n\n";
					if(!$virtual_host)
						$message['apachevhosts'] .= "*** WARNING: No VirtualHost defined\n\n";
					if(!$default_server || !$virtual_host)
						$message['apachevhosts'] .= "\n================== COMPLETE RESULT ==================\n".$output;
				}
			}
		}
		echo $message['apachevhosts'];
	}
	echo "\nPress ENTER to continue...";
}

trim(fgets(STDIN));

?>