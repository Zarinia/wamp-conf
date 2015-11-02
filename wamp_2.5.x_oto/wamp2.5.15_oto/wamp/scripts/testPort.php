<?php
require 'config.inc.php';
$only_process = false;
if(!empty($_SERVER['argv'][2]) && $_SERVER['argv'][2] == $c_mysqlService) {
	$port = isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : '3306';
	$only_process = true;
}
else	
	$port = isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : '80';

echo "***** Test which uses port ".$port." *****\n\n";
echo "===== Tested by command netstat filtered on port ".$port." =====\n\n";
//Port tested by netstat
$command = 'start /b /wait netstat -anop TCP | find ":'.$port.'"';
ob_start();
passthru($command);
$output = ob_get_contents();
ob_end_clean();
if(!empty($output)) {
	if(preg_match("~^[ \t]*TCP.*:".$port." .*LISTENING[ \t]*([0-9]{1,5}).*$~m", $output, $pid) > 0) {
		echo "Your port ".$port." is used by a processus with PID = ".$pid[1]."\n\n";
		$command = 'start /b /wait tasklist /FI "PID eq '.$pid[1].'" /FO TABLE /NH';
		ob_start();
		passthru($command);
		$output = ob_get_contents();
		ob_end_clean();
		if(!empty($output)) {
			if(preg_match("~^(.+[^ \t])[ \t]+".$pid[1]." ([a-zA-Z]+[^ \t]*).+$~m", $output, $matches) > 0) {
				echo "The processus of PID ".$pid[1]." is '".$matches[1]."' Session: ".$matches[2]."\n"; 
				$command = 'start /b /wait tasklist /SVC | find "'.$pid[1].'"';
				ob_start();
				passthru($command);
				$output = ob_get_contents();
				ob_end_clean();
				if(!empty($output)) {
					if(preg_match("~^(.+[^ \t])[ \t]+".$pid[1]." ([a-zA-Z]+[^ \t]*).+$~m", $output, $matches) > 0) {
						echo "The service of PID ".$pid[1]." for '".$matches[1]."' is '".$matches[2]."'\n";
						if($matches[2] == $_SERVER['argv'][2])
							echo "This service is from Wampserver - It is correct\n";
						else
							echo "*** ERROR *** This service IS NOT from Wampserver - Should be: '".$_SERVER['argv'][2]."'\n";
					}
				}
			}
			else
				echo "The processus of PID ".$pid[1]." is not found with tasklist\n";
		}
	}
	else
	 	echo "Port ".$port." is not found associated with TCP protocol\n";
}
else
	echo "Port ".$port." is not found associated with TCP protocol\n";

if(!$only_process) {
	echo "\n===== Tested by attempting to open a socket on port ".$port." =====\n\n";
	//Port tested by open socket
	$fp = @fsockopen("127.0.0.1", $port, $errno, $errstr, 1);
	$out = "GET / HTTP/1.1\r\n";
	$out .= "Host: 127.0.0.1\r\n";
	$out .= "Connection: Close\r\n\r\n";
	if ($fp) {
		echo  "Your port ".$port." is actually used by :\n\n";
		fwrite($fp, $out);
		while (!feof($fp)) {
			$line = fgets($fp, 128);
			if (preg_match('#Server:#',$line))	{
				echo $line;
				$gotInfo = 1;
			}
		}
		fclose($fp);
		if ($gotInfo != 1)
		echo "Server information not available (might be Skype or IIS).\n";
	}
	else {
		echo "Your port ".$port." is not actually used.\n";
	}
}
echo '

Press Enter to exit...';
trim(fgets(STDIN));

?>