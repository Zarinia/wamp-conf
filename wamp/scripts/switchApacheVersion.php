<?php
//[modif oto]
// Mise à jour dynamique ancienne version Apache utilisée
// 3.0.5 Eventually copy VirtualHost configuration file
//3.0.6

require 'config.inc.php';
require 'wampserver.lib.php';

$newApacheVersion = $_SERVER['argv'][1];

// loading the configuration file of the current php
require $c_phpVersionDir.'/php'.$wampConf['phpVersion'].'/'.$wampBinConfFiles;

// it is verified that the new version of Apache is compatible with the current php
$newApacheVersionTemp = $newApacheVersion;
while (!isset($phpConf['apache'][$newApacheVersionTemp]) && $newApacheVersionTemp != '')
{
    $pos = strrpos($newApacheVersionTemp,'.');
    $newApacheVersionTemp = substr($newApacheVersionTemp,0,$pos);
}
if ($newApacheVersionTemp == '')
{
    exit();
}

// loading Wampserver configuration file of the new version of Apache
require $c_apacheVersionDir.'/apache'.$newApacheVersion.'/'.$wampBinConfFiles;

// copy of VirtualHost between Apache version of the 2.4 branch
if(substr($wampConf['apacheVersion'],0,3) == '2.4' && substr($newApacheVersion,0,3) == '2.4' && ($newApacheVersion != $c_apacheVersion)) {
	$oldVhost = $c_apacheVhostConfFile;
	$newVhost = $c_apacheVersionDir.'/apache'.$newApacheVersion.'/'.$wampConf['apacheConfDir'].'/extra/httpd-vhosts.conf';
	//if identical files, copy no asked
	$content1 = file($oldVhost, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$content2 = file($newVhost, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$diff = array_diff($content1, $content2);
	if(count($diff) > 0) {
		$virtualHost = check_virtualhost();
		$copyFile = false;
		if($virtualHost['include_vhosts'] && $virtualHost['vhosts_exist'] && $virtualHost['nb_Server'] > 0) {
			echo "\n\n**********************************************************\n";
			echo "** Want to copy the VirtualHost already configured for Apache ".$c_apacheVersion."\n";
			echo "** to Apache ".$newApacheVersion."?\n\n";
			echo "Hit y then Enter for 'YES' - Enter for 'NO'\n\n";
			$touche = strtoupper(trim(fgets(STDIN)));
			if($touche === "Y") {
				if(copy($oldVhost,$newVhost) === false) {
					echo "\n\n**** Copy error ****\n\nPress ENTER to continue...\n";
					trim(fgets(STDIN));
				}
				else
					$copyFile = true;
			}
		}
		//Check Include conf/extra/httpd-vhosts.conf uncommented in new Apache version
		if($copyFile) {
			$c_apacheNewConfFile = $c_apacheVersionDir.'/apache'.$newApacheVersion.'/'.$wampConf['apacheConfDir'].'/'.$wampConf['apacheConfFile'];
			$httpConfFileContents = file_get_contents($c_apacheNewConfFile);
			$httpConfFileContents = preg_replace("~^[ \t]*#[ \t]*(Include[ \t]*conf/extra/httpd-vhosts.conf.*)$~m","$1",$httpConfFileContents,1,$count);
			if($count == 1) {
				$fp = fopen($c_apacheNewConfFile,'wb');
				fwrite($fp,$httpConfFileContents);
				fclose($fp);
			}
		}
	}
}

$apacheConf['apacheVersion'] = $newApacheVersion;
// Renseigne l'ancienne version Apache
$apacheConf['apacheLastKnown'] = $wampConf['apacheVersion'];
wampIniSet($configurationFile, $apacheConf);


?>