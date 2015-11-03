<?php
//[modif oto]
// Mise � jour dynamique ancienne version MariaDB utilis�e

require 'wampserver.lib.php';
require 'config.inc.php';

$newMariadbVersion = $_SERVER['argv'][1];

//on charge le fichier de conf de la nouvelle version
require $c_mariadbVersionDir.'/mariadb'.$newMariadbVersion.'/'.$wampBinConfFiles;

// Renseigne ancienne version MariaDB
$mariadbConf['mariadbLastKnown'] = $wampConf['mariadbVersion'];
$mariadbConf['mariadbVersion'] = $newMariadbVersion;

wampIniSet($configurationFile, $mariadbConf);

?>