<?php
//[modif oto]
// Mise à jour dynamique ancienne version MySQL utilisée
//3.0.6

require 'config.inc.php';
require 'wampserver.lib.php';

$newMysqlVersion = $_SERVER['argv'][1];

//on charge le fichier de conf de la nouvelle version
require $c_mysqlVersionDir.'/mysql'.$newMysqlVersion.'/'.$wampBinConfFiles;

// Renseigne ancienne version MySQL
$mysqlConf['mysqlLastKnown'] = $wampConf['mysqlVersion'];
$mysqlConf['mysqlVersion'] = $newMysqlVersion;

wampIniSet($configurationFile, $mysqlConf);

?>