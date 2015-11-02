<?php
// [modif oto] - script pour changer le port de Mysql
require 'config.inc.php';
require 'wampserver.lib.php';

//Replace UsedMysqlPort by NewMysqlport ($_SERVER['argv'][1])
$portToUse = intval(trim($_SERVER['argv'][1]));
//Check validity
$goodPort = true;
if($portToUse < 3301 || $portToUse > 3309)
	$goodPort = false;

if($goodPort) {
	//Change port into my.ini
	$mySqlIniFileContents = @file_get_contents($c_mysqlConfFile) or die ("my.ini file not found");
	$nb_myIni = 0; //must be three replacements: [client], [wampmysqld] and [mysqld] groups
	$myInReplace = false;
	$findTxtRegex = array(
	'/^(port)[ \t]*=.*$/m',
	);
	$mySqlIniFileContents = preg_replace($findTxtRegex,"$1 = ".$portToUse, $mySqlIniFileContents, -1, $nb_myIni);
	if($nb_myIni == 3)
		$myIniReplace = true;
	
	//Change port into php.ini
	$phpIniFileContents = @file_get_contents($c_phpConfFile) or die ("php.ini file not found");
	$nb_phpIni = 0; //must be two replacements
	$phpIniReplace = false;
	$findTxtRegex = array(
	'/^(mysql.default_port)[ \t]*=.*$/m',
	'/^(mysqli.default_port)[ \t]*=.*$/m',
	);
	$phpIniFileContents = preg_replace($findTxtRegex,"$1 = ".$portToUse, $phpIniFileContents, -1, $nb_phpIni);
	if($nb_phpIni == 2)
		$phpIniReplace = true;
		
	if($myIniReplace && $phpIniReplace) {
		$myIni = fopen($c_mysqlConfFile ,"w");
		fwrite($myIni,$mySqlIniFileContents);
		fclose($myIni);

		$phpIni = fopen($c_phpConfFile ,"w");
		fwrite($phpIni,$phpIniFileContents);
		fclose($phpIni);

		$myIniConf['mysqlPortUsed'] = $portToUse;
		if($portToUse == $c_DefaultMysqlPort)
			$myIniConf['mysqlUseOtherPort'] = "off";
		else
			$myIniConf['mysqlUseOtherPort'] = "on";
		wampIniSet($configurationFile, $myIniConf);
	}
}
else {
	echo "The port number you give: ".$portToUse."\n\n";
	echo "is not valid (Must be between 3301 and 3309)\n";
	echo "\nPress ENTER to continue...";
  trim(fgets(STDIN));
}

?>
