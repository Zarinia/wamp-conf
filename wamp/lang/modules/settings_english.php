<?php
// Default English language file for
// Projects and VirtualHosts sub-menus
// Settings and Tools right-click sub-menus
// 3.0.6 add NotCheckVirtualHost - Alias menu's
// 3.0.7 add $w_listenForApache - $w_AddListenPort - $w_deleteListenPort - $w_settings['SupportMariaDB']
// $w_settings['DaredevilOptions']
// $w_Size - $w_EnterSize - $w_Time - $w_EnterTime - $w_Integer - $w_EnterInteger - $w_add_VirtualHost
// 3.0.8 $w_settings['SupportMySQL'] - $w_portUsedMaria - $w_testPortMariaUsed
// 3.0.9 $w_ext_zend
// 3.1.1 $w_defaultDBMS - $w_invertDefault - $w_changeCLI - $w_misc
// $w_settings['ShowphmyadMenu'] - $w_settings['ShowadminerMenu']

// Projects sub-menu
$w_projectsSubMenu = 'Your projects';
// VirtualHosts sub-menu
$w_virtualHostsSubMenu = 'Your VirtualHosts';
$w_add_VirtualHost = 'VirtualHost Management';
$w_aliasSubMenu = 'Your Aliases';
$w_portUsed = 'Port used by Apache: ';
$w_portUsedMysql = 'Port used by MySQL: ';
$w_portUsedMariadb = 'Port used by MariaDB: ';
$w_testPortUsed = 'Test port used: ';
$w_portForApache = 'Port for Apache';
$w_listenForApache = 'Listen Port to add to Apache';
$w_portForMysql = 'Port for MySQL';
$w_portForMariadb = 'Port for MariaDB';
$w_testPortMysql = 'Test port 3306';
$w_testPortMariadb = 'Test port 3307';
$w_testPortMysqlUsed = 'Test MySQL port used: ';
$w_testPortMariadbUsed = 'Test MariaDB port used: ';
$w_enterPort = 'Enter the desired port number';

// Right-click Settings
$w_wampSettings = 'Wamp Settings';
$w_settings['urlAddLocalhost'] = 'Add localhost in url';
$w_settings['VirtualHostSubMenu'] = 'VirtualHosts sub-menu';
$w_settings['AliasSubmenu'] = 'Alias sub-menu';
$w_settings['ProjectSubMenu'] = 'Projects sub-menu';
$w_settings['HomepageAtStartup'] = 'Wampserver Homepage at startup';
$w_settings['MenuItemOnline'] = 'Menu item: Online / Offline';
$w_settings['ItemServicesNames'] = 'Tools menu item: Change services names';
$w_settings['NotCheckVirtualHost'] = 'Don\'t check VirtualHost definitions';
$w_settings['NotCheckDuplicate'] = 'Don\'t check duplicate ServerName';
$w_settings['VhostAllLocalIp'] = 'Allow VirtualHost local IP\'s others than 127.*';
$w_settings['SupportMySQL'] = 'Allow MySQL';
$w_settings['SupportMariaDB'] = 'Allow MariaDB';
$w_settings['DaredevilOptions'] = 'Caution: Risky! Only for experts.';
$w_settings['ShowphmyadMenu'] = 'Show PhpMyAdmin in Menu';
$w_settings['ShowadminerMenu'] = 'Show Adminer in Menu';

// Right-click Tools
$w_wampTools = 'Tools';
$w_restartDNS = 'Restart DNS';
$w_testConf = 'Check httpd.conf syntax';
$w_testServices = 'Check state of services';
$w_changeServices = 'Change the names of services';
$w_enterServiceNameApache = "Enter an index number for the Apache service. It will be added to 'wampapache'";
$w_enterServiceNameMysql = "Enter an index number for the Mysql service. It will be added to 'wampmysqld'";
$w_enterServiceNameMariadb = "Enter an index number for the Mariadb service. It will be added to 'wampmariadb'";
$w_compilerVersions = 'Check Compiler VC, compatibility and ini files';
$w_UseAlternatePort = 'Use a port other than %s';
$w_AddListenPort = 'Add a Listen port for Apache';
$w_vhostConfig = 'Show VirtualHost examined by Apache';
$w_apacheLoadedModules = 'Show Apache loaded Modules';
$w_empty = 'Empty';
$w_misc = 'Miscellaneous';
$w_emptyAll = 'Empty ALL';
$w_dnsorder = 'Check DNS search order';
$w_deleteVer = 'Delete unused versions';
$w_deleteListenPort = 'Delete a Listen port Apache';
$w_delete = 'Delete';
$w_defaultDBMS = 'Default DBMS:';
$w_invertDefault = 'Invert default DBMS ';
$w_changeCLI = 'Change PHP CLI version';

//miscellaneous
$w_ext_spec = 'Special extensions';
$w_ext_zend = 'Zend extensions';
$w_phpparam_info = 'For information only';
$w_ext_nodll = 'No dll file';
$w_ext_noline = "No 'extension='";
$w_mod_fixed = "Irreversible module";
$w_no_module = 'No module file';
$w_no_moduleload = "No 'LoadModule'";
$w_mysql_none = "none";
$w_mysql_user = "user mode";
$w_mysql_default = "by default";
$w_Size = "Size";
$w_EnterSize = "Enter Size: xxxx followed by M for Mega or G for Giga";
$w_Time = "Time";
$w_EnterTime = "Enter time in seconds";
$w_Integer = "Integer Value";
$w_EnterInteger = "Enter an integer";

?>