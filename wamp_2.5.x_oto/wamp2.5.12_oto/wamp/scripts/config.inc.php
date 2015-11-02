<?php

$configurationFile = '../wampmanager.conf';
$templateFile = '../wampmanager.tpl';
$wampserverIniFile = '../wampmanager.ini';
$langDir = '../lang/';
$aliasDir = '../alias/';
$modulesDir = 'modules/';
$logDir = 'logs/';
$wampBinConfFiles = 'wampserver.conf';
$phpConfFileForApache = 'phpForApache.ini';

// on charge la conf locale
$wampConf = @parse_ini_file($configurationFile);

//on renseigne les variables du template avec la conf locale
$c_installDir = $wampConf['installDir'];
$c_wampVersion = $wampConf['wampserverVersion'];
$c_navigator = $wampConf['navigator'];
$c_editor = $wampConf['editor'];

//Variable suppressLocalhost based on urlAddLocalhost
$c_suppressLocalhost = true;
if(isset($wampConf['urlAddLocalhost']) && $wampConf['urlAddLocalhost'] != "off")
	$c_suppressLocalhost = false;
	
//Ajout variables pour les ports
$c_DefaultPort = "80";
$c_UsedPort = isset($wampConf['apachePortUsed']) ? $wampConf['apachePortUsed'] : '';
$c_DefaultMysqlPort = "3306";
$c_UsedMysqlPort = isset($wampConf['mysqlPortUsed']) ? $wampConf['mysqlPortUsed'] : '';

$c_apacheService = $wampConf['ServiceApache'];
$c_mysqlService = $wampConf['ServiceMysql'];

$c_phpCliVersion = $wampConf['phpCliVersion'];
$c_mysqlVersion = $wampConf['mysqlVersion'];
$c_mysqlServiceInstallParams = $wampConf['mysqlServiceInstallParams'];
$c_mysqlServiceRemoveParams = $wampConf['mysqlServiceRemoveParams'];
$c_apacheServiceInstallParams = $wampConf['apacheServiceInstallParams'];
$c_apacheServiceRemoveParams = $wampConf['apacheServiceRemoveParams'];
$c_webgrind = "webGrind";


// on construit les variables correspondant aux chemins 
$c_apacheVersionDir = $wampConf['installDir'].'/bin/apache';
$c_phpVersionDir = $wampConf['installDir'].'/bin/php';
$c_mysqlVersionDir = $wampConf['installDir'].'/bin/mysql';
$c_apacheConfFile = $c_apacheVersionDir.'/apache'.$wampConf['apacheVersion'].'/'.$wampConf['apacheConfDir'].'/'.$wampConf['apacheConfFile'];
$c_apacheVhostConfFile = $c_apacheVersionDir.'/apache'.$wampConf['apacheVersion'].'/'.$wampConf['apacheConfDir'].'/extra/httpd-vhosts.conf';
$c_apacheExe = $c_apacheVersionDir.'/apache'.$wampConf['apacheVersion'].'/'.$wampConf['apacheExeDir'].'/'.$wampConf['apacheExeFile'];
$c_phpConfFile = $c_apacheVersionDir.'/apache'.$wampConf['apacheVersion'].'/'.$wampConf['apacheExeDir'].'/'.$wampConf['phpConfFile'];
$c_phpCliConfFile = $c_phpVersionDir.'/php'.$c_phpCliVersion.'/'.$wampConf['phpConfFile'];
$c_mysqlExe = $c_mysqlVersionDir.'/mysql'.$wampConf['mysqlVersion'].'/'.$wampConf['mysqlExeDir'].'/'.$wampConf['mysqlExeFile'];
$c_mysqlConfFile = $c_mysqlVersionDir.'/mysql'.$wampConf['mysqlVersion'].'/'.$wampConf['mysqlConfDir'].'/'.$wampConf['mysqlConfFile'];
$c_phpExe = $c_phpVersionDir.'/php'.$c_phpCliVersion.'/'.$wampConf['phpExeFile'];
$c_phpCli = $c_phpVersionDir.'/php'.$c_phpCliVersion.'/'.$wampConf['phpCliFile'];
$c_mysqlConsole = $c_mysqlVersionDir.'/mysql'.$c_mysqlVersion.'/'.$wampConf['mysqlExeDir'].'/mysql.exe';

$phpExtDir = $c_phpVersionDir.'/php'.$wampConf['phpVersion'].'/ext/';
$helpFile = $c_installDir.'/help/wamp5.chm';
$wwwDir = $c_installDir.'/www';

//dll to create symbolic links from php to apache/bin
$icu = array(
	'number' => array('53', '52', '51', '50','49'),
	'name' => array('icudt', 'icuin', 'icuio',	'icule', 'iculx',	'icutest', 'icutu', 'icuuc'),
	);
$php_icu_dll = array();
foreach($icu['number'] as $icu_number) {
	foreach($icu['name'] as $icu_name) {
		$php_icu_dll[] = $icu_name.$icu_number.".dll";
	}
}

$phpDllToCopy = array_merge(
	$php_icu_dll,
	array (
	'libeay32.dll',
	'libsasl.dll',
	'libssh2.dll', //For php 5.5.17
	'php5isapi.dll',
	'php5nsapi.dll',
	'ssleay32.dll',
	'php5ts.dll',
	)
);

$phpParams = array (
	'allow url fopen'=>'allow_url_fopen',
	'allow url include' => 'allow_url_include',
	'allowc call time pass reference'=>'allow_call_time_pass_reference',
	'asp tags' => 'asp_tags',
	'display errors'=>'display_errors',
	'display startup errors'=>'display_startup_errors',
	'enable dl'=>'enable_dl',
	'expose PHP'=>'expose_php',
	'file uploads'=>'file_uploads',
	'ignore repeated errors'=>'ignore_repeated_errors',
	'ignore repeated source'=>'ignore_repeated_source',
	'implicit flush'=>'implicit_flush',
	'log errors' => 'log_errors',
	'magic quotes gpc'=>'magic_quotes_gpc',
	'magic quotes runtime'=>'magic_quotes_runtime',
	'magic quotes sybase'=>'magic_quotes_sybase',
	'output buffering' => 'output_buffering',
	'register argc argv'=>'register_argc_argv',
	'register globals'=>'register_globals',
	'register long arrays'=>'register_long_arrays',
	'report memleaks'=>'report_memleaks',
	'safe mode'=>'safe_mode',
	'short open tag' => 'short_open_tag',
	'track errors'=>'track_errors',
	'y2k compliance'=>'y2k_compliance',
	'ze1 compatibility mode'=>'zend.ze1_compatibility_mode',
	'zend.enable_gc' => 'zend.enable_gc',
	'zlib output compression'=>'zlib.output_compression',
	'(XDebug) :  Profiler Enable Trigger' => 'xdebug.profiler_enable_trigger',
	'(XDebug) :  Profiler' => 'xdebug.profiler_enable',
	'(XDebug) :  Remote debug' => 'xdebug.remote_enable',
	);

//[modif oto] - Adding parameters to WampServer modifiable
//   by "Settings" sub-menu on right-click Wampmanager icon
$wamp_Param = array(
	'VirtualHostSubMenu',
	'ProjectSubMenu',
	'HomepageAtStartup',
	'MenuItemOnline',
	'ItemServicesNames',
	'urlAddLocalhost',
	);

//[modif oto] - Adding parameters for Apache & MySQL
$apache_Param = $apache_Param_value = array();
$apache_Param[] = 'apacheUseOtherPort';
$apache_Param_Value[] = 'off';
$apache_Param[] = 'apachePortUsed';
$apache_Param_Value[] = '80';

$mysql_Param = $mysql_Param_value = array();
$mysql_Param[] = 'mysqlUseOtherPort';
$mysql_Param_Value[] = 'off';
$mysql_Param[] = 'mysqlPortUsed';
$mysql_Param_Value[] = '3306';

//[modif oto] - Extensions can not be loaded by extension =
// for example zend_extension
$phpNotLoadExt = array(
	'php_opcache',
	);
//[modif oto] - Apache modules which should not be disabled
$apacheModNotDisable = array(
	'php5_module',
	);

?>
