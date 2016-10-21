<?php
//3.0.6

require 'config.inc.php';

$myIniFileContents = @file_get_contents($c_mysqlConfFile) or die ("my.ini file not found");

if ($_SERVER['argv'][2] == 'off')
{
    $findTxt  = $_SERVER['argv'][1].' = On';
    $replaceTxt  = $_SERVER['argv'][1].' = Off';
}
else
{
    $findTxt  = $_SERVER['argv'][1].' = Off';
    $replaceTxt  = $_SERVER['argv'][1].' = On';
}


$myIniFileContents = str_ireplace($findTxt,$replaceTxt,$myIniFileContents);

$fpMyIni = fopen($c_mysqlConfFile,"w");
fwrite($fpMyIni,$myIniFileContents);
fclose($fpMyIni);


?>