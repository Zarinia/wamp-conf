<?php

function wampIniSet($iniFile, $params)
{
	$iniFileContents = @file_get_contents($iniFile);
	foreach ($params as $param => $value)
	$iniFileContents = preg_replace('|'.$param.' = .*|',$param.' = '.'"'.$value.'"',$iniFileContents);
	$fp = fopen($iniFile,'w');
	fwrite($fp,$iniFileContents);
	fclose($fp);
}

function listDir($dir,$toCheck = '')
{
	if ($handle = opendir($dir))
	{
		while (false !== ($file = readdir($handle)))
		{
			if ($file != "." && $file != ".." && is_dir($dir.'/'.$file))
			{
				if ($toCheck != '')
				{
					eval('$result ='." $toCheck('$dir','$file');");
				}
				if (!isset($result) || $result == 1)
					$list[] = $file;
			}
		}
		closedir($handle);
	}
	if (isset($list))
		return($list);
	else
		return (NULL);
}

function checkPhpConf($baseDir,$version)
{
	global $wampBinConfFiles;
	global $phpConfFileForApache;

	if (!is_file($baseDir.'/'.$version.'/'.$wampBinConfFiles))
		return (0);
	if (!is_file($baseDir.'/'.$version.'/'.$phpConfFileForApache))
		return (0);
	return(1);
}

function checkApacheConf($baseDir,$version)
{
	global $wampBinConfFiles;

	if (!is_file($baseDir.'/'.$version.'/'.$wampBinConfFiles))
		return (0);
	return(1);
}

function checkMysqlConf($baseDir,$version)
{
	global $wampBinConfFiles;

	if (!is_file($baseDir.'/'.$version.'/'.$wampBinConfFiles))
		return (0);
	return(1);
}

function linkPhpDllToApacheBin($php_version)
{
	require 'config.inc.php';

	//Create symbolic link instead of copy dll's files
	foreach ($phpDllToCopy as $dll)
	{
		$target = $c_phpVersionDir.'/php'.$php_version.'/'.$dll;
		$link = $c_apacheVersionDir.'/apache'.$wampConf['apacheVersion'].'/'.$wampConf['apacheExeDir'].'/'.$dll;
		if(is_file($link) || is_link($link))
			unlink($link);
		if (is_file($target))
			symlink($target, $link);
	}
	//Create apache/apachex.y.z/bin/php.ini link to phpForApache.ini file of active version of PHP
	$target = $c_phpVersionDir."/php".$php_version."/".$phpConfFileForApache;
	$link = $c_apacheVersionDir."/apache".$wampConf['apacheVersion']."/".$wampConf['apacheExeDir']."/php.ini";
	if(is_file($link) || is_link($link))
		unlink($link);
	symlink($target, $link);
}

function switchPhpVersion($newPhpVersion)
{
	require 'config.inc.php';

	//on charge le fichier de conf de la nouvelle version
	require $c_phpVersionDir.'/php'.$newPhpVersion.'/'.$wampBinConfFiles;

	//on determine les textes httpd.conf en fonction de la version d'apache
	$apacheVersion = $wampConf['apacheVersion'];
	while (!isset($phpConf['apache'][$apacheVersion]) && $apacheVersion != '')
	{
		$pos = strrpos($apacheVersion,'.');
		$apacheVersion = substr($apacheVersion,0,$pos);

	}

	// on modifie le fichier de conf d'apache
	$httpdContents = file($c_apacheConfFile);
	$newHttpdContents = '';
	foreach ($httpdContents as $line)
	{
		if (strstr($line,'LoadModule') && strstr($line,'php'))
		{
			$newHttpdContents .= 'LoadModule '.$phpConf['apache'][$apacheVersion]['LoadModuleName'].' "'.$c_phpVersionDir.'/php'.$newPhpVersion.'/'.$phpConf['apache'][$apacheVersion]['LoadModuleFile'].'"'."\r\n";
		}
    elseif (!empty($phpConf['apache'][$apacheVersion]['AddModule']) && strstr($line,'AddModule') && strstr($line,'php'))
    	$newHttpdContents .= 'AddModule '.$phpConf['apache'][$apacheVersion]['AddModule']."\r\n";
		else
			$newHttpdContents .= $line;
	}
	file_put_contents($c_apacheConfFile,$newHttpdContents);


	//on modifie la conf de wampserver
	$wampIniNewContents['phpIniDir'] = $phpConf['phpIniDir'];
	$wampIniNewContents['phpExeDir'] = $phpConf['phpExeDir'];
	$wampIniNewContents['phpConfFile'] = $phpConf['phpConfFile'];
	// Renseigne ancienne version PHP
	$wampIniNewContents['phpLastKnown'] = $wampConf['phpVersion'];
	$wampIniNewContents['phpVersion'] = $newPhpVersion;
	wampIniSet($configurationFile, $wampIniNewContents);
	
	//Create symbolic link to php dll's and to phpForApache.ini of new version
	linkPhpDllToApacheBin($newPhpVersion);

}

// Function test of IPv6 support
function test_IPv6() {
	if (extension_loaded('sockets')) {
		//Create socket IPv6
		$socket = socket_create(AF_INET6, SOCK_RAW, 1) ;
		if($socket === false) {
			$errorcode = socket_last_error() ;
			$errormsg = socket_strerror($errorcode);
			//echo "<p>Error socket IPv6: ".$errormsg."</p>\n" ;
			return false;
		}
		else {
			//echo "<p>IPv6 supported</p>\n" ;
			socket_close($socket);
			return true;
		}
	}
	else echo "<p>Extension PHP sockets not loaded</p>\n" ;
	return false;
}

?>