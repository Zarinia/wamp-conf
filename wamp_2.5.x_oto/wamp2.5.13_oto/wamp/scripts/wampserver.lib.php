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
	clearstatcache();
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

// Create parameter in $configurationFile file
// $name = parameter name -- $value = parameter value
// $section = name of the section to add parameter after
function createWampConfParam($name, $value, $section, $configurationFile) {
	$wampConfFileContents = @file_get_contents($configurationFile) or die ($configurationFile."file not found");
	$addTxt = $name.' = "'.$value.'"';
	$wampConfFileContents = str_replace($section,$section."\r\n".$addTxt,$wampConfFileContents);
	$fpWampConf = fopen($configurationFile,"w");
	fwrite($fpWampConf,$wampConfFileContents);
	fclose($fpWampConf);
}

//Function to switch on (uncommented) or off (commented with ; at the beginning)
//lines in a file
function update_wampmanager_file($item_on, $test_value, $equal_to_on, $equal_to_off, $file) {
	$wampFileContents = @file_get_contents($file) or die ($file." file not found");
	$item_off = ";".$item_on;
	$item_is_off = $item_is_on = $replace_tpl = false;
	if(strpos($wampFileContents, $item_off) !== false)
		$item_is_off = true;
	elseif(strpos($wampFileContents, $item_on) !== false)
		$item_is_on = true;
	if($item_is_on && $test_value == $equal_to_off) {
		$wampFileContents = str_replace($item_on, $item_off, $wampFileContents);
		$replace_tpl = true;
	}
	if($item_is_off && $test_value == $equal_to_on) {
		$wampFileContents = str_replace($item_off, $item_on, $wampFileContents);
		$replace_tpl = true;
	}
	if($replace_tpl)
		file_put_contents($file, $wampFileContents);
}

// Function to check if VirtualHost exist and are valid
function check_virtualhost($check_files_only = false) {
	require 'config.inc.php';
	clearstatcache();
	$virtualHost = array(
		'include_vhosts' => true,
		'vhosts_exist' => true,
		'nb_Server' => 0,
		'ServerName' => array(),
		'ServerNameValid' => array(),
		'nb_Virtual' => 0,
		'nb_Virtual_Port' => 0,
		'virtual_port' => array(),
		'nb_Document' => 0,
		'documentPath' => array(),
		'documentPathValid' => array(),
		'document' => true,
		'nb_Directory' => 0,
		'nb_End_Directory' => 0,
		'directoryPath' => array(),
		'directoryPathValid' => array(),
		'directory' => true,
		'port_number' => true,
	);
	$httpConfFileContents = file_get_contents($c_apacheConfFile);
	//is Include conf/extra/httpd-vhosts.conf uncommented?
	if(preg_match("~^[ \t]*#[ \t]*Include[ \t]*conf/extra/httpd-vhosts.conf.*$~m",$httpConfFileContents) > 0) {
		$virtualHost['include_vhosts'] = false;
		return $virtualHost;
	}

	$virtualHost['vhosts_file'] = $c_apacheVhostConfFile;
	if(!file_exists($virtualHost['vhosts_file'])) {
		$virtualHost['vhosts_exist'] = false;
		return $virtualHost;
	}
	if($check_files_only) {
		return $virtualHost;
	}
		
	$myVhostsContents = file_get_contents($virtualHost['vhosts_file']);
	// Extract values of ServerName (without # at the beginning of the line)
	$nb_Server = preg_match_all("/^(?![ \t]*#).*ServerName(.*)$/m", $myVhostsContents, $Server_matches);
	// Extract values of <VirtualHost *:xx> port number
	$nb_Virtual = preg_match_all("/^(?![ \t]*#).*<VirtualHost \*:(.*)>\R/m", $myVhostsContents, $Virtual_matches);
	// Extract values of DocumentRoot path
	$nb_Document = preg_match_all("/^(?![ \t]*#).*DocumentRoot (.*)$/m", $myVhostsContents, $Document_matches);
	// Count number of <Directory that has to match the number of ServerName
	$nb_Directory = preg_match_all("/^(?![ \t]*#).*<Directory (.*)>\R/m", $myVhostsContents, $Dir_matches);
	$nb_End_Directory = preg_match_all("~^(?![ \t]*#).*</Directory.*$~m", $myVhostsContents, $end_Dir_matches);
	$server_name = array();
	if($nb_Server == 0) {
		$virtualHost['nb_server'] = 0;
		return $virtualHost;
	}
	$virtualHost['nb_Server'] = $nb_Server;
	$virtualHost['nb_Virtual'] = $nb_Virtual;
	$virtualHost['nb_Virtual_Port'] = count($Virtual_matches[1]);
	$virtualHost['nb_Document'] = $nb_Document;
	$virtualHost['nb_Directory'] = $nb_Directory;
	$virtualHost['nb_End_Directory'] = $nb_End_Directory;
	//Check validity of port number
	$port_ref = $Virtual_matches[1][0];
	$virtualHost['virtual_port'] = array_merge($Virtual_matches[0]);
	for($i = 0 ; $i < count($Virtual_matches[1]) ; $i++) {
		$port = intval($Virtual_matches[1][$i]);
		if(empty($port) || !is_numeric($port) || $port < 80 || $port > 65535 || $port != $port_ref) {
			$virtualHost['port_number'] = false;
		}
	}
	
	//Check validity of DocumentRoot
	for($i = 0 ; $i < $nb_Document ; $i++) {
		$chemin = trim($Document_matches[1][$i], " \t\n\r\0\x0B\"");
		$virtualHost['documentPath'][$i] = $chemin;
		if(!file_exists($chemin) || !is_dir($chemin)) {
			$virtualHost['documentPathValid'][$chemin] = false;
			$virtualHost['document'] = false;
		}
		else
			$virtualHost['documentPathValid'][$chemin] = true;
	}

	//Check validity of Directory path
	for($i = 0 ; $i < $nb_Directory ; $i++) {
		$chemin = trim($Dir_matches[1][$i], " \t\n\r\0\x0B\"");
		$virtualHost['directoryPath'][$i] = $chemin;
		if(!file_exists($chemin) || !is_dir($chemin)) {
			$virtualHost['directoryPathValid'][$chemin] = false;
			$virtualHost['directory'] = false;
		}
		else
			$virtualHost['directoryPathValid'][$chemin] = true;
	}
	
	//Check validity of ServerName
	for($i = 0 ; $i < $nb_Server ; $i++) {
		$value = trim($Server_matches[1][$i]);
		$virtualHost['ServerName'][$value] = $value;

		//Validity of ServerName (Like domain name)
		//   /^[A-Za-z0-9]([-.](?![-.])|[A-Za-z0-9]){1,60}[A-Za-z0-9]$/
		if(preg_match('/^
			[A-Za-z0-9]			# letter or number at the beginning
			(								# characters neither at the beginning nor at the end
				[-.](?![-.])	#  a . or - not followed by . or -
						|					#   or
				[A-Za-z0-9]		#  a letter or a number
			){1,60}					# this, repeated from 1 to 60 times
			[A-Za-z0-9]			# letter ou number at the end
			$/x',$value) == 0) {
			$virtualHost['ServerNameValid'][$value] = false;
		}
		elseif(strpos($value,"dummy-host") !== false || strpos($value,"example.com") !== false) {
			$virtualHost['ServerNameValid'][$value] = 'dummy';
		}
		else {
			$virtualHost['ServerNameValid'][$value] = true;
		}
	} //End for

	return $virtualHost;

}
// Get content of file and set lines end to DOS (CR/LF) if needed
function file_get_contents_dos($file, $retour = true) {
	$check_DOS = @file_get_contents($file) or die ($file."file not found");
	//Check if there is \n without previous \r
	if(preg_match("/(?<!\r)\n/",$check_DOS) > 0) {
		$check_DOS = preg_replace(array("/\r\n?/","/\n/"),array("\n","\r\n"), $check_DOS);
		$file_write = fopen($file,"w");
		fwrite($file_write,$check_DOS);
		fclose($file_write);
	}
	if($retour) return $check_DOS;
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