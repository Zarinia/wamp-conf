<?php

require 'config.inc.php';

$httpdFileContents = @file_get_contents($c_apacheConfFile ) or die ("httpd.conf file not found");

//Uncomment or comment LoadModule line
if ($_SERVER['argv'][2] == 'on')
{
    $findTxt  = 'LoadModule '.$_SERVER['argv'][1];
    $replaceTxt  = '#LoadModule '.$_SERVER['argv'][1];
}
else
{
    $findTxt  = '#LoadModule '.$_SERVER['argv'][1];
    $replaceTxt  = 'LoadModule '.$_SERVER['argv'][1];
}

$httpdFileContents = str_replace($findTxt,$replaceTxt,$httpdFileContents);

//Comment or Uncomment #Include conf/extra/httpd-autoindex.conf line
if($_SERVER['argv'][1] == "autoindex_module") {
	if ($_SERVER['argv'][2] == 'on') {
	    $findTxt  = 'Include conf/extra/httpd-autoindex.conf';
	    $replaceTxt  = '#Include conf/extra/httpd-autoindex.conf';
	}
	else	{
	    $findTxt  = '#Include conf/extra/httpd-autoindex.conf';
	    $replaceTxt  = 'Include conf/extra/httpd-autoindex.conf';
	}
	$httpdFileContents = str_replace($findTxt,$replaceTxt,$httpdFileContents);
}

$fphttpd = fopen($c_apacheConfFile ,"w");
fwrite($fphttpd,$httpdFileContents);
fclose($fphttpd);


?>