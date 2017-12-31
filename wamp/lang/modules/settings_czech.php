<?php
// Default English language file for
// Projects and VirtualHosts sub-menus
// Settings and Tools right-click sub-menus
// 3.0.7 add $w_listenForApache - $w_AddListenPort - $w_deleteListenPort - $w_settings['SupportMariaDB']
// $w_settings['DaredevilOptions']
// $w_Size - $w_EnterSize - $w_Time - $w_EnterTime - $w_Integer - $w_EnterInteger - $w_add_VirtualHost
// 3.0.8 $w_settings['SupportMySQL'] - $w_portUsedMaria - $w_testPortMariaUsed
// 3.0.9 $w_ext_zend
// 3.1.1 $w_defaultDBMS - $w_invertDefault - $w_changeCLI - $w_misc

// translated by František Bartoš (Bart, admin@bart.cz)

// Projects sub-menu
$w_projectsSubMenu = 'Projekty';
// VirtualHosts sub-menu
$w_virtualHostsSubMenu = 'VirtualHosts';
$w_add_VirtualHost = 'Pøidat VirtualHost';
$w_aliasSubMenu = 'Aliasy';
$w_portUsed = 'Port používaný službou Apache: ';
$w_portUsedMysql = 'Port používaný službou MySQL: ';
$w_portUsedMaria = 'Port používaný službou MariaDB : ';
$w_testPortUsed = 'Otestovat používaný port: ';
$w_portForApache = 'Port pro Apache';
$w_listenForApache = 'Nastavit port pro naslouchání Apache';
$w_portForMysql = 'Port pro MySQL';
$w_testPortMysql = 'Otestovat port 3306';
$w_testPortMysqlUsed = 'Otestovat používaný port službou MySQL: ';
$w_testPortMariaUsed = 'Otestovat používaný port službou MariaDB: ';
$w_enterPort = 'Zadejte požadované èíslo portu';

// Right-click Settings
$w_wampSettings = 'Wamp nastavení';
$w_settings['urlAddLocalhost'] = 'Pøidat adresu localhost do URL projektu';
$w_settings['VirtualHostSubMenu'] = 'Zobrazit sub-menu VirtualHosts';
$w_settings['AliasSubmenu'] = 'Zobrazit sub-menu Aliasy';
$w_settings['ProjectSubMenu'] = 'Zobrazit sub-menu Projekty';
$w_settings['HomepageAtStartup'] = 'Zobrazit Pøehled pøi startu WampServer';
$w_settings['MenuItemOnline'] = 'Zobrazit položku v menu: Nastavit Online / Offline';
$w_settings['ItemServicesNames'] = 'Zobrazit položku v menu: Zmìnit název služeb ve Službách Windows';
$w_settings['NotCheckVirtualHost'] = 'Nekontrolovat definice VirtualHost';
$w_settings['NotCheckDuplicate'] = 'Nekontrolovat duplicitní ServerName';
$w_settings['VhostAllLocalIp'] = 'Povolit pro VirtualHost i jinou místní IP adresu než je 127.*';
$w_settings['SupportMySQL'] = 'Povolit MySQL';
$w_settings['SupportMariaDB'] = 'Povolit MariaDB';
$w_settings['DaredevilOptions'] = 'Upozornìní: Riziková nastavení! Pouze pro experty.';

// Right-click Tools
$w_wampTools = 'Nástroje';
$w_restartDNS = 'Restartovat DNS';
$w_testConf = 'Zkontrolovat syntaxi httpd.conf';
$w_testServices = 'Zkontrolovat stav služeb';
$w_changeServices = 'Zmìnit název služeb ve Službách Windows';
$w_enterServiceNameApache = "Zadejte indexové èíslo pro službu Apache. Bude pøidáno do služby 'wampapache'";
$w_enterServiceNameMysql = "Zadejte indexové èíslo pro službu Mysql. Bude pøidáno do služby 'wampmysqld'";
$w_compilerVersions = 'Zkontrolovat Compiler VC, kompatibilitu a ini soubory';
$w_UseAlternatePort = 'Použít jiný port než je %s';
$w_AddListenPort = 'Nastavit port pro naslouchání Apache';
$w_vhostConfig = 'Zobrazit pøezkoumaný VirtualHost provádìný Apache';
$w_apacheLoadedModules = 'SZobrazit naètené MODULY Apache';
$w_empty = 'Vyèistit';
$w_misc = 'Rùzné';
$w_emptyAll = 'Vyèistit všechny';
$w_dnsorder = 'Zkontrolovat poøadí DNS záznamù pro vyhledávání';
$w_deleteVer = 'Odstranit nepoužívané verze';
$w_deleteListenPort = 'Odstranit port pro naslouchání Apache';
$w_delete = 'Odstranit';
$w_defaultDBMS = 'Výchozí DBMS (Systém øízení báze dat):';
$w_invertDefault = 'Zmìnit výchozí DBMS ';
$w_changeCLI = 'Zmìnit verzi PHP CLI';

//miscellaneous
$w_ext_spec = 'Speciální rozšíøení';
$w_ext_zend = 'Zend rozšíøení';
$w_phpparam_info = 'Pouze pro informaci';
$w_ext_nodll = 'Žádný dll soubor';
$w_ext_noline = "Žádné 'rozšíøení='";
$w_mod_fixed = "Nezmìnitelný modul";
$w_no_module = 'Žádný modul';
$w_no_moduleload = "Žádný 'LoadModule'";
$w_mysql_none = "žádný";
$w_mysql_user = "uživatelský mód";
$w_mysql_default = "ve výchozím stavu";
$w_Size = "Velikost";
$w_EnterSize = "Zadejte velikost: xxxx ve formátu M pro Mega nebo G pro Giga";
$w_Time = "Èas";
$w_EnterTime = "Zadejte èas v sekundách";
$w_Integer = "Hodnota Integer (celé èíslo)";
$w_EnterInteger = "Zadejte celé èíslo";

?>