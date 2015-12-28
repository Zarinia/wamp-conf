<?php
//Update 3.0.1
//Support for Apache 2.2

require ('wampserver.lib.php');
require 'config.inc.php';

$httpConfFileContents = file_get_contents($c_apacheConfFile) or die ("httpd.conf file not found");

// Findind permissions and prohibitions access from "onlineoffline tag" line in httpd.conf
// preg_replace regex explanations
// $0 = all block, for example:
/* [0] => #   onlineoffline tag - don't remove
    Require local
    Require ip 192.163.10.2
</Directory>
*/
// $1 = First line: [1] => #   onlineoffline tag - don't remove
/* $2 = Directives
[2] =>
    Require local
    Require ip 192.163.10.2
*/
// $3 = Last line: [3] => </Directory>

$apacheType = substr($wampConf['apacheVersion'],0,3);

//Test of Apache version for cohabition of Apache 2.4 and Apache 2.2
if($apacheType == "2.4") {
	$onlineText  = "    Require all granted";
	$offlineText = "    Require local";
}
else {
	$onlineText = "    Order Allow,Deny
    Allow from all";
	if(test_IPv6()) {
		$offlineText = "    Order Deny,Allow
    Deny from all
    Allow from localhost ::1 127.0.0.1";
  }
  else {
		$offlineText = "    Order Deny,Allow
    Deny from all
    Allow from localhost 127.0.0.1";
  }
}

// We modify httpd.conf file
if ($_SERVER['argv'][1] == 'off') {
	$replacement = "\n".$offlineText."\n";;
	$wampIniNewContents['status'] = 'offline';
}
elseif ($_SERVER['argv'][1] == 'on') {
	$replacement = "\n".$onlineText."\n";
	$wampIniNewContents['status'] = 'online';
}
$nb = 0;
$httpConfFileContents = preg_replace("~(^[ \t]*#[ \t]*onlineoffline tag.*\r?$)((?:.|\r?\n)+?)(^[ \t]*</Directory>\r?$)~m", "$1".$replacement."$3", $httpConfFileContents, -1, $nb);

if($nb == 1) {
	$fpHttpd = fopen($c_apacheConfFile,"w");
	fwrite($fpHttpd,$httpConfFileContents);
	fclose($fpHttpd);
	//write new configuration
	wampIniSet($configurationFile, $wampIniNewContents);
}
else {
	echo "The line\n\n#   onlineoffline tag - don't remove\n\n";
	echo "was not found in\n".$c_apacheConfFile."\n\n";
	echo "\nPress ENTER to continue...";
  trim(fgets(STDIN));
}
?>