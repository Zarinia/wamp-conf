<?php
// [modif oto] - script ajout� pour g�rer les nouveaux param�tres
// de configuration ajout�s � wampmanager.conf

require ('wampserver.lib.php');

require 'config.inc.php';

if($_SERVER['argv'][2] == 'create') {
	createWampConfParam($_SERVER['argv'][1],$_SERVER['argv'][3],$_SERVER['argv'][4],$configurationFile);
}
else {
	$wampIniNewContents[$_SERVER['argv'][1]] = $_SERVER['argv'][2];
	wampIniSet($configurationFile, $wampIniNewContents);
}
?>