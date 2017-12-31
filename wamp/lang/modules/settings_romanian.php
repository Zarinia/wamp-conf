<?php
// Romanian language file for
// Projects and VirtualHosts sub-menus
// Settings and Tools right-click sub-menus
// Translated by Ciprian Murariu <ciprianmp[at]yahoo[dot]com>
// 3.0.7 add $w_listenForApache - $w_AddListenPort - $w_deleteListenPort - $w_settings['SupportMariaDB']
// $w_settings['DaredevilOptions']
// $w_Size - $w_EnterSize - $w_Time - $w_EnterTime - $w_Integer - $w_EnterInteger - $w_add_VirtualHost
// 3.0.8 $w_settings['SupportMySQL'] - $w_portUsedMaria - $w_testPortMariaUsed
// 3.0.9 $w_ext_zend
// 3.1.1 $w_defaultDBMS - $w_invertDefault - $w_changeCLI - $w_misc
// $w_settings['ShowphmyadMenu'] - $w_settings['ShowadminerMenu']

// Projects sub-menu
$w_projectsSubMenu = 'Proiecte personale';
// VirtualHosts sub-menu
$w_virtualHostsSubMenu = 'VirtualHosts';
$w_add_VirtualHost = 'Administrare VirtualHost';
$w_aliasSubMenu = 'Aliasuri';
$w_portUsed = 'Portul curent Apache: ';
$w_portUsedMysql = 'Portul curent MySQL: ';
$w_portUsedMariadb = 'Portul curent MariaDB: ';
$w_testPortUsed = 'Testeazã portul curent: ';
$w_portForApache = 'Portul Apache';
$w_listenForApache = 'Portul de Intrare pentru adãugare la Apache';
$w_portForMysql = 'Portul MySQL';
$w_portForMariadb = 'Portul MariaDB';
$w_testPortMysql = 'Testeazã portul 3306';
$w_testPortMariadb = 'Testeazã portul 3307';
$w_testPortMysqlUsed = 'Testeazã portul MySQL: ';
$w_testPortMariadbUsed = 'Testeazã portul MariaDB: ';
$w_enterPort = 'Introdu numãrul noului port';

// Right-click Settings
$w_wampSettings = 'Setãri Wamp';
$w_settings['urlAddLocalhost'] = 'Adaugã localhost la începutul url-ului';
$w_settings['VirtualHostSubMenu'] = 'Aratã Sub-meniul VirtualHosts';
$w_settings['AliasSubmenu'] = 'Aratã Sub-meniul Alias';
$w_settings['ProjectSubMenu'] = 'Aratã Sub-meniul Proiecte personale';
$w_settings['HomepageAtStartup'] = 'Deschide pagina Index la pornire';
$w_settings['MenuItemOnline'] = 'Aratã în Meniu: Online / Offline';
$w_settings['ItemServicesNames'] = 'Aratã în Instrumente: Schimbã numele serviciilor';
$w_settings['NotCheckVirtualHost'] = 'Nu verifica definiþiile VirtualHost';
$w_settings['NotCheckDuplicate'] = 'Nu verifica dublarea Numelui Serverului';
$w_settings['VhostAllLocalIp'] = 'Permite utilizarea IP-urilor locale, altele decât 127.*';
$w_settings['SupportMySQL'] = 'Permite utilizarea MySQL';
$w_settings['SupportMariaDB'] = 'Permite utilizarea MariaDB';
$w_settings['DaredevilOptions'] = 'Atenþie: Riscant! Numai pentru experþi.';
$w_settings['ShowphmyadMenu'] = 'Aratã phpMyAdmin în Meniu';
$w_settings['ShowadminerMenu'] = 'Aratã Adminer în Meniu';

// Right-click Tools
$w_wampTools = 'Instrumente';
$w_restartDNS = 'Reporneºte DNS';
$w_testConf = 'Verificã sintaxa httpd.conf';
$w_testServices = 'Verificã starea serviciilor';
$w_changeServices = 'Schimbã numele serviciilor';
$w_enterServiceNameApache = "Introdu un numãr de ordine pentru serviciul Apache. Acest numãr va fi adãugat la sfârºitul cuvântului 'wampapache'";
$w_enterServiceNameMysql = "Introdu un numãr de ordine pentru serviciul Mysql. Acest numãr va fi adãugat la sfârºitul cuvântului 'wampmysqld'";
$w_compilerVersions = 'Verificã compilatorul VC, compatibilitatea ºi fiºierele ini';
$w_UseAlternatePort = 'Foloseºte alt port decât %s';
$w_AddListenPort = 'Adaugã un port de Intrare pentru Apache';
$w_vhostConfig = 'Aratã VirtualHost verificat de Apache';
$w_apacheLoadedModules = 'Aratã Modulele încãrcate de Apache';
$w_empty = 'Goleºte';
$w_misc = 'Diverse';
$w_emptyAll = 'Goleºte TOATE';
$w_dnsorder = 'Verificã ordinea de cãutare a DNS';
$w_deleteVer = 'ªterge versiunile neutilizate';
$w_deleteListenPort = 'ªterge un port de Intrare Apache';
$w_delete = 'ªterge';
$w_defaultDBMS = 'DBMS implicit:';
$w_invertDefault = 'Inverseazã DBMS implicit ';
$w_changeCLI = 'Schimbã versiunea PHP CLI';

//miscellaneous
$w_ext_spec = 'Extensii speciale';
$w_ext_zend = 'Extensii Zend';
$w_phpparam_info = 'Informaþii suplimentare';
$w_ext_nodll = 'Fiºier dll inexistent';
$w_ext_noline = "Nu existã 'extensie='";
$w_mod_fixed = "Module ireversibile";
$w_no_module = 'Fiºier modul inexistent';
$w_no_moduleload = "Nu existã 'LoadModule'";
$w_mysql_none = "niciunul";
$w_mysql_user = "modul utilizator";
$w_mysql_default = "implicit";
$w_Size = "Mãrimea";
$w_EnterSize = "Introdu Mãrimea: xxxx urmat de M pentru Mega sau G pentru Giga";
$w_Time = "Timul";
$w_EnterTime = "Introdu timpul în secunde";
$w_Integer = "Numãr Întreg";
$w_EnterInteger = "Introdu un numãr întreg";

?>