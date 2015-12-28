<?php
//Update 3.0.1
//$c_wampMode 32 or 64 bit
//Support for Edge

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
$c_wampMode = $wampConf['wampserverMode'];
$c_navigator = $wampConf['navigator'];
//For Windows 10 and Edge it is not the same as for other browsers
//It is not complete path to browser with parameter http://website/
//but by 'cmd.exe /c "start /b Microsoft-Edge:http://website/"'
$c_edge = "";
if($c_navigator == "Edge") {
	//Check if Windows 10
	if(php_uname('r') < 10) {
		error_log("Edge should be defined as default navigator only with Windows 10");
		if(file_exists("c:/Program Files (x86)/Internet Explorer/iexplore.exe"))
			$c_navigator = "c:/Program Files (x86)/Internet Explorer/iexplore.exe";
		elseif(file_exists("c:/Program Files/Internet Explorer/iexplore.exe"))
			$c_navigator = "c:/Program Files/Internet Explorer/iexplore.exe";
		else
			$c_navigateor = "iexplore.exe";
	}
	else {
	$c_navigator = "cmd.exe";
	$c_edge = "/c start /b Microsoft-Edge:";
	}
}
$c_editor = $wampConf['editor'];

//Variable suppressLocalhost based on urlAddLocalhost
$c_suppressLocalhost = true;
if(isset($wampConf['urlAddLocalhost']) && $wampConf['urlAddLocalhost'] != "off")
	$c_suppressLocalhost = false;

//Ajout variables pour les ports
$c_DefaultPort = "80";
$c_AlternatePort = "8080";
$c_UsedPort = isset($wampConf['apachePortUsed']) ? $wampConf['apachePortUsed'] : '';
$c_DefaultMysqlPort = "3306";
$c_AlternateMysqlPort = "3305";
$c_UsedMysqlPort = isset($wampConf['mysqlPortUsed']) ? $wampConf['mysqlPortUsed'] : '';
$c_DefaultMariadbPort = "3307";
$c_AlternateMariadbPort = "3308";
$c_UsedMariadbPort = isset($wampConf['mariadbPortUsed']) ? $wampConf['mariadbPortUsed'] : '';

$c_apacheService = $wampConf['ServiceApache'];
$c_mysqlService = $wampConf['ServiceMysql'];
$c_mariadbService = $wampConf['ServiceMariadb'];

$c_phpCliVersion = $wampConf['phpCliVersion'];
$c_mysqlVersion = $wampConf['mysqlVersion'];
$c_mysqlServiceInstallParams = $wampConf['mysqlServiceInstallParams'];
$c_mysqlServiceRemoveParams = $wampConf['mysqlServiceRemoveParams'];
$c_mariadbVersion = $wampConf['mariadbVersion'];
$c_mariadbServiceInstallParams = $wampConf['mariadbServiceInstallParams'];
$c_mariadbServiceRemoveParams = $wampConf['mariadbServiceRemoveParams'];
$c_apacheServiceInstallParams = $wampConf['apacheServiceInstallParams'];
$c_apacheServiceRemoveParams = $wampConf['apacheServiceRemoveParams'];
$c_webgrind = "webGrind";


// on construit les variables correspondant aux chemins
$c_apacheVersionDir = $wampConf['installDir'].'/bin/apache';
$c_phpVersionDir = $wampConf['installDir'].'/bin/php';
$c_mysqlVersionDir = $wampConf['installDir'].'/bin/mysql';
$c_mariadbVersionDir = $wampConf['installDir'].'/bin/mariadb';
$c_apacheConfFile = $c_apacheVersionDir.'/apache'.$wampConf['apacheVersion'].'/'.$wampConf['apacheConfDir'].'/'.$wampConf['apacheConfFile'];
$c_apacheVhostConfFile = $c_apacheVersionDir.'/apache'.$wampConf['apacheVersion'].'/'.$wampConf['apacheConfDir'].'/extra/httpd-vhosts.conf';
$c_apacheAutoIndexConfFile = $c_apacheVersionDir.'/apache'.$wampConf['apacheVersion'].'/'.$wampConf['apacheConfDir'].'/extra/httpd-autoindex.conf';
$c_apacheExe = $c_apacheVersionDir.'/apache'.$wampConf['apacheVersion'].'/'.$wampConf['apacheExeDir'].'/'.$wampConf['apacheExeFile'];
$c_phpConfFile = $c_apacheVersionDir.'/apache'.$wampConf['apacheVersion'].'/'.$wampConf['apacheExeDir'].'/'.$wampConf['phpConfFile'];
$c_phpCliConfFile = $c_phpVersionDir.'/php'.$c_phpCliVersion.'/'.$wampConf['phpConfFile'];
$c_mysqlExe = $c_mysqlVersionDir.'/mysql'.$wampConf['mysqlVersion'].'/'.$wampConf['mysqlExeDir'].'/'.$wampConf['mysqlExeFile'];
$c_mysqlConfFile = $c_mysqlVersionDir.'/mysql'.$wampConf['mysqlVersion'].'/'.$wampConf['mysqlConfDir'].'/'.$wampConf['mysqlConfFile'];
$c_mariadbExe = $c_mariadbVersionDir.'/mariadb'.$wampConf['mariadbVersion'].'/'.$wampConf['mariadbExeDir'].'/'.$wampConf['mariadbExeFile'];
$c_mariadbConfFile = $c_mariadbVersionDir.'/mariadb'.$wampConf['mariadbVersion'].'/'.$wampConf['mariadbConfDir'].'/'.$wampConf['mariadbConfFile'];
$c_phpExe = $c_phpVersionDir.'/php'.$c_phpCliVersion.'/'.$wampConf['phpExeFile'];
$c_phpCli = $c_phpVersionDir.'/php'.$c_phpCliVersion.'/'.$wampConf['phpCliFile'];
$c_mysqlConsole = $c_mysqlVersionDir.'/mysql'.$c_mysqlVersion.'/'.$wampConf['mysqlExeDir'].'/mysql.exe';
$c_mariadbConsole = $c_mariadbVersionDir.'/mariadb'.$c_mariadbVersion.'/'.$wampConf['mariadbExeDir'].'/mysql.exe';

//Test du fichier hosts
$c_hostsFile = getenv('WINDIR').'\system32\drivers\etc\hosts';
$c_hostsFile_writable = true;
if(file_exists($c_hostsFile)) {
	if(!is_file($c_hostsFile))
		error_log($c_hostsFile." is not a file");
	if(!is_writable($c_hostsFile)) {
		if(@chmod($c_hostsFile, 0644) === false)
			error_log("Impossible to modify the file ".$c_hostsFile." to be writable");
		if(!is_writable($c_hostsFile)) {
			error_log("The file ".$c_hostsFile." is not writable");
			$c_hostsFile_writable = false;
		}
	}
}
else {
	error_log("The file ".$c_hostsFile." does not exists");
	$c_hostsFile_writable = false;
}

$phpExtDir = $c_phpVersionDir.'/php'.$wampConf['phpVersion'].'/ext/';
$helpFile = $c_installDir.'/help/wamp5.chm';
$wwwDir = $c_installDir.'/www';

//dll to create symbolic links from php to apache/bin
// 55 & 56 for PHP 7
$icu = array(
	'number' => array('56', '55', '54', '53', '52', '51', '50', '49'),
	'name' => array('icudt', 'icuin', 'icuio', 'icule', 'iculx', 'icutest', 'icutu', 'icuuc'),
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
	'libpq.dll',
	'libssh2.dll', //For php 5.5.17
	'php5isapi.dll',
	'php5nsapi.dll',
	'ssleay32.dll',
	'php5ts.dll',
	'php7ts.dll', //For PHP 7
	)
);

$phpParams = array (
	'allow url fopen'=>'allow_url_fopen',
	'allow url include' => 'allow_url_include',
	'allowc call time pass reference'=>'allow_call_time_pass_reference',
	'asp tags'=>'asp_tags',
	'auto globals jit' => 'auto_globals_jit',
	'date.timezone' => 'date.timezone',
	'default_charset' => 'default_charset',
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
	'memory_limit'=>'memory_limit',
	'output_buffering' => 'output_buffering',
	'post_max_size'=>'post_max_size',
	'register argc argv'=>'register_argc_argv',
	'register globals'=>'register_globals',
	'register long arrays'=>'register_long_arrays',
	'report memleaks'=>'report_memleaks',
	'safe mode'=>'safe_mode',
	'short open tag' => 'short_open_tag',
	'track errors'=>'track_errors',
	'upload_max_filesize'=>'upload_max_filesize',
	'y2k compliance'=>'y2k_compliance',
	'ze1 compatibility mode'=>'zend.ze1_compatibility_mode',
	'zend.enable_gc' => 'zend.enable_gc',
	'intl.default_locale' => 'intl.default_locale',
	'zlib output compression'=>'zlib.output_compression',
	'(XDebug) :  Profiler Enable Trigger' => 'xdebug.profiler_enable_trigger',
	'(XDebug) :  Profiler' => 'xdebug.profiler_enable',
	'(XDebug) :  Remote debug' => 'xdebug.remote_enable',
	'mysql.default_port' => 'mysql.default_port', // mysql default port
	'mysqli.default_port' => 'mysqli.default_port', // mysqli default port
	);

// Adding parameters to WampServer modifiable
// by "Settings" sub-menu on right-click Wampmanager icon
$wamp_Param = array(
	'VirtualHostSubMenu',
	'ProjectSubMenu',
	'HomepageAtStartup',
	'MenuItemOnline',
	'ItemServicesNames',
	'urlAddLocalhost',
	);

/*
remove from wamp 3
// Adding parameters for Apache & MySQL & MariaDB
$apache_Param = $apache_Param_value = array();
$apache_Param[] = 'apacheUseOtherPort';
$apache_Param_Value[] = 'off';
$apache_Param[] = 'apachePortUsed';
$apache_Param_Value[] = $c_DefaultPort;

$mysql_Param = $mysql_Param_value = array();
$mysql_Param[] = 'mysqlUseOtherPort';
$mysql_Param_Value[] = 'off';
$mysql_Param[] = 'mysqlPortUsed';
$mysql_Param_Value[] = $c_DefaultMysqlPort;

$mariadb_Param = $mariadb_Param_value = array();
$mariadb_Param[] = 'mariadbUseOtherPort';
$mariadb_Param_Value[] = 'off';
$mariadb_Param[] = 'mariadbPortUsed';
$mariadb_Param_Value[] = $c_DefaultMariadbPort;
*/
// Extensions can not be loaded by extension =
// for example zend_extension
$phpNotLoadExt = array(
	'php_opcache',
	);

// Apache modules which should not be disabled
$apacheModNotDisable = array(
	'authz_core_module',
	'php5_module',
	'php7_module',
	);

?>
