<?php
// script to change MySQL port used
// [modif 3.0.2] for PHP 7 has no more mysql but only mysqli

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
	// For $wampConf['phpVersion']    = $c_phpConfFile
	// For $wampConf['phpCliVersion'] = $c_phpCliConfFile
	// First for PHP (not CLI)
	$phpIniFileContents = @file_get_contents($c_phpConfFile) or die ("php.ini file not found");
	$nb_phpIni = 0; //must be one (PHP 7) or two (PHP 5.6) replacements
	if (version_compare($wampConf['phpVersion'], '7.0.0', '>=')) {
	  $findTxtRegex = '/^(mysqli.default_port)[ \t]*=.*$/m';
	  $nb_replace = 1;
	}
	else {
		$findTxtRegex = array(
		'/^(mysql.default_port)[ \t]*=.*$/m',
		'/^(mysqli.default_port)[ \t]*=.*$/m');
		$nb_replace = 2;
	}
	$phpIniReplace = false;
	$phpIniFileContents = preg_replace($findTxtRegex,"$1 = ".$portToUse, $phpIniFileContents, -1, $nb_phpIni);
	if($nb_phpIni == $nb_replace)
		$phpIniReplace = true;

	// Second for PHP CLI
	$phpIniCliFileContents = @file_get_contents($c_phpCliConfFile) or die ("php.ini file not found");
	$nb_phpIni = 0; //must be one (PHP 7) or two (PHP 5.6) replacements
	if (version_compare($wampConf['phpCliVersion'], '7.0.0', '>=')) {
	  $findTxtRegex = '/^(mysqli.default_port)[ \t]*=.*$/m';
	  $nb_replace = 1;
	}
	else {
		$findTxtRegex = array(
		'/^(mysql.default_port)[ \t]*=.*$/m',
		'/^(mysqli.default_port)[ \t]*=.*$/m');
		$nb_replace = 2;
	}
	$phpIniCliReplace = false;
	$phpIniCliFileContents = preg_replace($findTxtRegex,"$1 = ".$portToUse, $phpIniCliFileContents, -1, $nb_phpIni);
	if($nb_phpIni == $nb_replace)
		$phpIniCliReplace = true;

	if($myIniReplace && $phpIniReplace && $phpIniCliReplace) {
		$myIni = fopen($c_mysqlConfFile ,"w");
		fwrite($myIni,$mySqlIniFileContents);
		fclose($myIni);

		$phpIni = fopen($c_phpConfFile ,"w");
		fwrite($phpIni,$phpIniFileContents);
		fclose($phpIni);

		$phpCliIni = fopen($c_phpCliConfFile ,"w");
		fwrite($phpCliIni,$phpIniCliFileContents);
		fclose($phpCliIni);

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
