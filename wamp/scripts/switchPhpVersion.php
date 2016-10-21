<?php
//3.0.6

require 'config.inc.php';
require 'wampserver.lib.php';

$newPhpVersion = $_SERVER['argv'][1];

switchPhpVersion($newPhpVersion);

?>