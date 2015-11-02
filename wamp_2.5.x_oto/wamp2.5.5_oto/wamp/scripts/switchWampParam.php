<?php
// [modif oto] - script ajouté après Wampserver 2.5 pour gérer les nouveaux paramètres
// de configuration ajoutés à la fin de la section [main] de wampmanager.conf

require ('wampserver.lib.php');

require 'config.inc.php';

if($_SERVER['argv'][2] == 'create') {
	//Recherche ligne juste avant la section [php]
	$wampConfLines = file($configurationFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$nb_key = array_search("[php]",$wampConfLines);
	if($nb_key !== false)
		$findTxt = $wampConfLines[$nb_key-1];
	else
		$findTxt = "[main]";
		
	$wampConfFileContents = @file_get_contents($configurationFile) or die ("wampmanager.conf file not found");
	
	$addTxt = $_SERVER['argv'][1].' = "off"';
	$wampConfFileContents = str_replace($findTxt,$findTxt."\n".$addTxt,$wampConfFileContents);
	$fpWampConf = fopen($configurationFile,"w");
	fwrite($fpWampConf,$wampConfFileContents);
	fclose($fpWampConf);
}
else {
	$wampIniNewContents[$_SERVER['argv'][1]] = $_SERVER['argv'][2];
	wampIniSet($configurationFile, $wampIniNewContents);
}
?>