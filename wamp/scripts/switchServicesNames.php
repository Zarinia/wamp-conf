<?php
// [modif oto] - script pour changer le nom des services
require 'config.inc.php';
require 'wampserver.lib.php';

$newServicesNames = array();
if(!empty($_SERVER['argv'][1])) {
	$numApache = intval(trim($_SERVER['argv'][1]));
	if($numApache < 0 || $numApache > 9999)
		$numApache = 0;
	$newApache = "wampapache".$numApache;
}
else
	$newApache = "wampapache";
	
if(!empty($_SERVER['argv'][2])) {
	$numMysql = intval(trim($_SERVER['argv'][2]));
	if($numMysql < 0 || $numMysql > 9999)
		$numMysql = 0;
	$newMysql = "wampmysqld".$numMysql;
}
else
	$newMysql = "wampmysqld";

if(!empty($_SERVER['argv'][3])) {
	$numMariadb = intval(trim($_SERVER['argv'][3]));
	if($numMariadb < 0 || $numMysql > 9999)
		$numMariadb = 0;
	$newMariadb = "wampmariadb".$numMariadb;
}
else
	$newMariadb = "wampmariadb";

$newServicesNames['ServiceApache'] = $newApache;
$newServicesNames['ServiceMysql'] = $newMysql;
$newServicesNames['ServicenewMariadb'] = $newMariadb;
$newServicesNames['apacheServiceInstallParams'] = "-n ".$newApache." -k install";
$newServicesNames['apacheServiceRemoveParams'] = "-n ".$newApache." -k uninstall";
$newServicesNames['mysqlServiceInstallParams'] = "--install-manual ".$newMysql;
$newServicesNames['mysqlServiceRemoveParams'] = "--remove ".$newMysql;
$newServicesNames['mariadbServiceInstallParams'] = "--install-manual ".$newMariadb;
$newServicesNames['mariadbServiceRemoveParams'] = "--remove ".$newMariadb;

//Replace services names in wampmanager.conf
wampIniSet($configurationFile, $newServicesNames);

//Install new services
//Install Apache service
$command = 'start /b /wait '.$c_apacheExe.' '.$newServicesNames['apacheServiceInstallParams'];
`$command`;

//Apache service to manual start
$command = "start /b /wait SC \\\\. config ".$newServicesNames['ServiceApache']." start=demand";
`$command`;

//Install Mysql service
$command = 'start /b /wait '.$c_mysqlExe.' '.$newServicesNames['mysqlServiceInstallParams'];
`$command`;

//Install Mariadb service
$command = 'start /b /wait '.$c_mariadbExe.' '.$newServicesNames['mariadbServiceInstallParams'];
`$command`;

?>
