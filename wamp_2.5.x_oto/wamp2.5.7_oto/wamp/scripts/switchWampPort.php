<?php
// [modif oto] - script ajouté après Wampserver 2.5 pour changer le port d'écoute de Wampserver

require ('wampserver.lib.php');
require 'config.inc.php';

//error_log("argument 1 =".$_SERVER['argv'][1]."|");
//Replace Used Port by New port ($_SERVER['argv'][1])
$portToUse = intval(trim($_SERVER['argv'][1]));
//Check validity
$goodPort = true;
if($portToUse < 80 || ($portToUse > 81 && $portToUse < 1025) || $portToUse > 65535)
	$goodPort = false;

if($goodPort) {
	//-- into httpd.conf
	$httpdFileContents = @file_get_contents($c_apacheConfFile ) or die ("httpd.conf file not found");
	
	$findTxt = array(
	"Listen 0.0.0.0:".$c_UsedPort,
	"Listen [::0]:".$c_UsedPort,
	"ServerName localhost:".$c_UsedPort,
	);
	$replaceTxt = array(
	"Listen 0.0.0.0:".$portToUse,
	"Listen [::0]:".$portToUse,
	"ServerName localhost:".$portToUse,);
	
	$httpdFileContents = str_replace($findTxt,$replaceTxt,$httpdFileContents);
	
	$fphttpd = fopen($c_apacheConfFile ,"w");
	fwrite($fphttpd,$httpdFileContents);
	fclose($fphttpd);
	
	//into httpd-vhosts.conf
	$c_vhostConfFile = $c_apacheVersionDir.'/apache'.$wampConf['apacheVersion'].'/'.$wampConf['apacheConfDir'].'/extra/httpd-vhosts.conf';
	$myVhostsContents = file_get_contents($c_vhostConfFile) or die ("httpd-vhosts.conf file not found");
	
	$findTxt = "<VirtualHost *:".$c_UsedPort.">";
	$replaceTxt = "<VirtualHost *:".$portToUse.">";
	
	$myVhostsContents = str_replace($findTxt,$replaceTxt,$myVhostsContents);
	
	$fphttpdVhosts = fopen($c_vhostConfFile ,"w");
	fwrite($fphttpdVhosts,$myVhostsContents);
	fclose($fphttpdVhosts);
	
	$apacheConf['apachePortUsed'] = $portToUse;
	if($portToUse == $c_DefaultPort)
		$apacheConf['apacheUseOtherPort'] = "off";
	else
		$apacheConf['apacheUseOtherPort'] = "on";
	wampIniSet($configurationFile, $apacheConf);
}
else {
	echo "The port number you give: ".$portToUse."\n\n";
	echo "is not valid\n";
	echo "\nPress ENTER to continue...";
  trim(fgets(STDIN));
}

?>
