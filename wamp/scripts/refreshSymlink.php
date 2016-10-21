<?php
//Update 3.0.4
//New script to rebuild symbolic links
//Script to rebuild symbolic links
//3.0.6 - Check symbolic links

require 'config.inc.php';
require 'wampserver.lib.php';

$newPhpVersion = $_SERVER['argv'][1];

linkPhpDllToApacheBin($newPhpVersion);

$checkSymlink = CheckSymlink($newPhpVersion);
if(!empty($checkSymlink)) {
	echo "***** WARNING *****\n\n";
	echo $checkSymlink;
	echo "\n--- Do you want to copy the results into Clipboard?
--- Type 'y' to confirm - Press ENTER to continue... ";
  $confirm = trim(fgetc(STDIN));
	$confirm = strtolower(trim($confirm ,'\''));
	if ($confirm == 'y') {
		$fp = fopen("temp.txt",'w');
		fwrite($fp,$checkSymlink);
		fclose($fp);
		$command = 'type temp.txt | clip';
		`$command`;
		$command = 'del temp.txt';
		`$command`;
		exit(0);
	}
}

?>
