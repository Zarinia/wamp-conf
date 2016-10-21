<?php
//3.0.6

require 'config.inc.php';
require 'wampserver.lib.php';

$wampIniNewContents['language'] = $_SERVER['argv'][1];

wampIniSet($configurationFile, $wampIniNewContents);
?>