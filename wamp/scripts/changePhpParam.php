<?php
//3.0.6 Change PHP parameters not on or off

require 'config.inc.php';

$phpIniFileContents = @file_get_contents($c_phpConfFile) or die ("php.ini file not found");

$quoted = false;
if($_SERVER['argv'][1] == 'quotes')
	$quoted = true;
$parameter = $_SERVER['argv'][2];
$newvalue = $_SERVER['argv'][3];
$changeError = '';

if(!empty($_SERVER['argv'][4])) {
	$choose = $_SERVER['argv'][4];
	if($choose == 'Seconds') {
		if(preg_match('/^[1-9][0-9]{1,3}$/m',$newvalue) != 1) {
		$changeError = <<< EOFERROR
The value you entered ({$newvalue}) is out of range.
The number of seconds must be between 10 and 9999.
The value is set to 300 seconds by default.
EOFERROR;
		$newvalue = '300';
		}
	}
	elseif($choose == 'Size') {
		$newvalue = strtoupper($newvalue);
		if(preg_match('/^[1-9][0-9]{1,3}(M|G)$/m',$newvalue) != 1) {
		$changeError = <<< EOF1ERROR
The value you entered ({$newvalue}) is out of range.
The number must be between 10 and 9999.
The number must be followed by M (For Mega) or G (For Giga)
The value is set to 128M by default.
EOF1ERROR;
		$newvalue = '128M';
		}
	}
}
if($quoted)
	$newvalue = '"'.$newvalue.'"';

$phpIniFileContents = preg_replace('|^'.$parameter.'[ \t]*=.*|m',$parameter.' = '.$newvalue,$phpIniFileContents, -1, $count);

if($count > 0) {
	$fpPhpIni = fopen($c_phpConfFile,"w");
	fwrite($fpPhpIni,$phpIniFileContents);
	fclose($fpPhpIni);
}

// Check if we need to modify also CLI php.ini
if(in_array($parameter,$phpCLIparams)) {
	$phpIniCLIFileContents = @file_get_contents($c_phpCliConfFile) or die ("php.ini file not found");
	$phpIniCLIFileContents = preg_replace('|^'.$parameter.'[ \t]*=.*|m',$parameter.' = '.$newvalue,$phpIniCLIFileContents, -1, $count);

	if($count > 0) {
		$fpPhpIni = fopen($c_phpCliConfFile,"w");
		fwrite($fpPhpIni,$phpIniCLIFileContents);
		fclose($fpPhpIni);
	}
}

if(!empty($changeError)) {
	echo "********************* WARNING ********************\n\n";
	echo $changeError;
	echo "\nPress ENTER to continue...";
  trim(fgets(STDIN));
}

?>