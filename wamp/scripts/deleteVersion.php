<?php
//3.0.6 Delete unused versions PHP, MySQL or Apache

function rrmdir($dir) {
	if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
			}
		}
		reset($objects);
		return rmdir($dir);
	}
}

require 'config.inc.php';

$type = $_SERVER['argv'][1];
$version = $_SERVER['argv'][2];

if($type == 'apache')
	$delDir = $c_apacheVersionDir.'/apache'.$version;
elseif($type == 'php')
	$delDir = $c_phpVersionDir.'/php'.$version;
elseif($type == 'mysql')
	$delDir = $c_mysqlVersionDir.'/mysql'.$version;
else {
	exit();
}
if(file_exists($delDir) && is_dir($delDir)) {
	//exec("rd /s /q {$delDir}");
	if(rrmdir($delDir) === false)
		error_log("Folder ".$delDir." not deleted");
}

?>