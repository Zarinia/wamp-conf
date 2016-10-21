<?php
//Update 3.0.1
//Added mode 32 or 64 bit in Quick Admin
//Support for Windows 10 and Edge
//Update 3.0.4
//Richt-Click Refresh include rebuild symlinks
//Update 3.0.5
//Add edit httpd-vhosts.conf file in Apache submenu
//Add check DNS order in Tools right submenu
//Update 3.0.6
//Prompt variable for Size or Time
//Delete old versions
//MySQL settings
//Alias sub-menu
//[modif oto] Sous menu Projets (My Projects) et/ou Virtuals Hosts
// Dans ;WAMPMENULEFTSTART ligne ajoutée après localhost
// ;WAMPPROJECTSUBMENU Pour les projets
// ;WAMPVHOSTSUBMENU Pour les Virtual Hosts
// Variables déclarées dans wampmanager.conf
// "notepad.exe" remplacé par "${c_editor}"
// services wampapache et wampmysqld
// wampapache remplacé par ${c_apacheService}
// wampmysqld remplacé par ${c_mysqlService}
// Attention : Les ajouts de variables susmentionnés nécessitent
//  les modifications des fichiers wampserver.conf, wampmanager.tpl,
//  config.inc.php, scripts/refresh et scripts/wampserver.lib.php

$tpl = <<< EOTPL
[Config]
;WAMPCONFIGSTART
ImageList=images_off.bmp
ServiceCheckInterval=1
ServiceGlyphRunning=13
ServiceGlyphPaused=14
ServiceGlyphStopped=15
TrayIconAllRunning=16
TrayIconSomeRunning=17
TrayIconNoneRunning=18
ID={wampserver}
AboutHeader=WAMPSERVER 2.5 (2.5.18) - 3.0 (${c_wampVersion})
AboutVersion=Version ${c_wampVersion}
;WAMPCONFIGEND

[AboutText]
WampServer Version ${c_wampVersion} ${c_wampMode}

Created by Romain Bourdon (romain@romainbourdon.com)
Maintainer / Upgrade / RoadMap by Herve Leclerc (herve.leclerc@alterway.fr)
Modified (2.5 to 2.5.18) by Otomatic (otomatic@otomatic.net)
Upgrade 2.5 to 3.0.0 by Otomatic (wampserver@otomatic.net)
Multi styles for homepage by Jojaba
MariaDB by Phlyper (phlyper@live.fr)
Upgrade 2.5.18 to 3.0.6 by Phlyper (phlyper@live.fr)

Installer by Inno Setup
Sources are available at SourceForge

http://www.wampserver.com
http://forum.wampserver.com/index.php
______________________ Versions used ______________________
Apache ${c_apacheVersion} - PHP ${c_phpVersion} - MySQL ${c_mysqlVersion} - MariaDb ${c_mariadbVersion}
PHP ${c_phpCliVersion} for CLI (Command-Line Interface)

[Services]
Name: ${c_apacheService}
Name: ${c_mysqlService}
Name: ${c_mariadbService}

[Variables]
Type: prompt; Name: "ApachePort"; PromptCaption: "${w_portForApache}"; PromptText: "${w_enterPort}"; DefaultValue: "${w_newPort}"
Type: prompt; Name: "MysqlPort"; PromptCaption: "${w_portForMysql}"; PromptText: "${w_enterPort}"; DefaultValue: "${w_newMysqlPort}"
Type: prompt; Name: "MariadbPort"; PromptCaption: "${w_portForMariadb}"; PromptText: "${w_enterPort}"; DefaultValue: "${w_newMariadbPort}"
Type: prompt; Name: "ApacheService"; PromptCaption: "Apache Service"; PromptText: "${w_enterServiceNameApache}"; DefaultValue: "25"
Type: prompt; Name: "MysqlService"; PromptCaption: "MySQL Service"; PromptText: "${w_enterServiceNameMysql}"; DefaultValue: "25"
Type: prompt; Name: "Size"; PromptCaption: "Size"; PromptText: "Enter Size: xxxx followed by M for Mega or G for Giga"; DefaultValue: "512M"
Type: prompt; Name: "Seconds"; PromptCaption: "Time"; PromptText: "Enter time in seconds"; DefaultValue: "360"
Type: prompt; Name: "MariadbService"; PromptCaption: "MariaDB Service"; PromptText: "${w_enterServiceNameMariadb}"; DefaultValue: "25"
Type: prompt; Name: "Size"; PromptCaption: "Size"; PromptText: "Enter Size: xxxx followed by M for Mega or G for Giga"; DefaultValue: "512M"
Type: prompt; Name: "Seconds"; PromptCaption: "Time"; PromptText: "Enter time in seconds"; DefaultValue: "360"

[Messages]
AllRunningHint=${w_serverOffline} - ${w_allServicesRunning}
SomeRunningHint=${w_serverOffline} - ${w_oneServiceRunning}
NoneRunningHint=${w_serverOffline} - ${w_allServicesStopped}

[StartupAction]
;WAMPSTARTUPACTIONSTART
Action: run; FileName: "${c_phpCli}"; Parameters: "checkWampFiles.php"; WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated
Action: run; FileName: "${c_phpCli}"; Parameters: "refresh.php";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated
Action: resetservices
Action: readconfig;
Action: service; Service: ${c_apacheService}; ServiceAction: startresume; Flags: ignoreerrors
Action: service; Service: ${c_mysqlService}; ServiceAction: startresume; Flags: ignoreerrors
Action: service; Service: ${c_mariadbService}; ServiceAction: startresume; Flags: ignoreerrors
${RunAtStart}Action: run; FileName: "${c_navigator}"; Parameters: "${c_edge}http://localhost${UrlPort}/"; ShowCmd: normal; Flags: ignoreerrors

;WAMPSTARTUPACTIONEND

[Menu.Right.Settings]
;WAMPMENURIGHTSETTINGSSTART
AutoLineReduction=no
BarVisible=no
SeparatorsAlignment=center
SeparatorsFade=yes
SeparatorsFadeColor=clBtnShadow
SeparatorsFlatLines=yes
SeparatorsGradientEnd=clSilver
SeparatorsGradientStart=clGray
SeparatorsGradientStyle=horizontal
SeparatorsFont=Arial,8,clWhite,bold
SeparatorsSeparatorStyle=caption
;WAMPMENURIGHTSETTINGSEND

[Menu.Left.Settings]
;WAMPMENULEFTSETTINGSSTART
AutoLineReduction=no
BarVisible=yes
BarCaptionAlignment=bottom
BarCaptionCaption=WAMPSERVER ${c_wampVersion}
BarCaptionDepth=1
BarCaptionDirection=downtoup
BarCaptionFont=Tahoma,14,clWhite,bold italic
BarCaptionHighlightColor=clNone
BarCaptionOffsetY=0
BarCaptionShadowColor=clNone
BarPictureHorzAlignment=center
BarPictureOffsetX=0
BarPictureOffsetY=0
BarPicturePicture=barimage.bmp
BarPictureTransparent=yes
BarPictureVertAlignment=bottom
BarBorder=clNone
BarGradientEnd=$00550000
BarGradientStart=clBlue
BarGradientStyle=horizontal
BarSide=left
BarSpace=0
BarWidth=32
SeparatorsAlignment=center
SeparatorsFade=yes
SeparatorsFadeColor=clBtnShadow
SeparatorsFlatLines=yes
SeparatorsFont=Arial,8,clWhite,bold
SeparatorsGradientEnd=$00FFAA55
SeparatorsGradientStart=$00550000
SeparatorsGradientStyle=horizontal
SeparatorsSeparatorStyle=caption
;WAMPMENULEFTSETTINGSEND

[Menu.Right]
;WAMPMENURIGHTSTART
Type: item; Caption: "${w_about}"; Action: about; Glyph: 22
Type: item; Caption: "${w_refresh}"; Action: multi; Actions: wampreload; Glyph: 12
Type: item; Caption: "${w_help}"; Action: run; FileName: "${c_navigator}"; Parameters: "${c_edge}http://www.wampserver.com/presentation.php"; Glyph: 31
Type: item; Caption: "${w_forum}"; Action: run; FileName: "${c_navigator}"; Parameters: "${c_edge}http://forum.wampserver.com/index.php"; Glyph: 31
Type: submenu; Caption: "${w_language}"; SubMenu: language; Glyph: 3
Type: submenu; Caption: "${w_wampSettings}"; Submenu: submenu.settings; Glyph: 25
Type: submenu; Caption: "${w_wampTools}"; Submenu: submenu.tools; Glyph: 29
Type: item; Caption: "${w_exit}"; Action: multi; Actions: myexit; Glyph: 30
;WAMPMENURIGHTEND

[wampreload]
;WAMPRELOADSTART
Action: service; Service: ${c_apacheService}; ServiceAction: stop; Flags: ignoreerrors waituntilterminated
Action: closeservices; Flags: ignoreerrors
Action: run; FileName: "${c_phpCli}";Parameters: "switchPhpVersion.php ${c_phpVersion}";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated
Action: run; FileName: "${c_phpCli}";Parameters: "refreshSymlink.php ${c_phpVersion}"; WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated
Action: run; FileName: "net"; Parameters: "start ${c_apacheService}"; ShowCmd: hidden; Flags: waituntilterminated
Action: run; FileName: "${c_phpCli}";Parameters: "refresh.php"; WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated
Action: resetservices
Action: readconfig;
;WAMPRELOADEND


[language]
;WAMPLANGUAGESTART
;WAMPLANGUAGEEND

[submenu.settings]
;WAMPSETTINGSSTART
;WAMPSETTINGSEND

[Menu.Left]
;WAMPMENULEFTSTART
Type: separator; Caption: "Powered by Alter Way (WampServer 2.5) - Made in France by Otomatic (WampServer 3.0)"
Type: item; Caption: "${w_localhost}"; Action: run; FileName: "${c_navigator}"; Parameters: "${c_edge}http://localhost${UrlPort}/"; Glyph: 27
Type: item; Caption: "${w_localhost}"; Action: run; FileName: "cmd.exe"; Parameters: "/c start /b Microsoft-Edge:http://localhost${UrlPort}/"; Glyph: 28
Type: item; Caption: "${w_phpmyadmin}"; Action: run; FileName: "${c_navigator}"; Parameters: "${c_edge}http://localhost${UrlPort}/phpmyadmin/"; Glyph: 28
;WAMPVHOSTSUBMENU
;WAMPALIASSUBMENU
;WAMPPROJECTSUBMENU

Type: item; Caption: "${w_wwwDirectory}"; Action: shellexecute; FileName: "${wwwDir}"; Glyph: 2
Type: submenu; Caption: "Apache"; SubMenu: apacheMenu; Glyph: 3
Type: submenu; Caption: "PHP"; SubMenu: phpMenu; Glyph: 3
Type: submenu; Caption: "MySQL"; SubMenu: mysqlMenu; Glyph: 3
Type: submenu; Caption: "MariaDB"; SubMenu: mariadbMenu; Glyph: 3
Type: separator; Caption: "Debug"
;Type: item; Caption: "Client XDebug"; Glyph: 6; Action: run; FileName: "${c_installDir}/tools/xdc/xdc.exe"
Type: item; Caption: "${c_webgrind}"; Action: run; FileName: "${c_navigator}"; Parameters: "http://localhost${UrlPort}/webgrind/"; Glyph: 5
Type: separator; Caption: "${c_wampMode} - Quick Admin"
;Type: servicesubmenu; Caption: "${w_apache}"; Service: ${c_apacheService}; SubMenu: apache
;Type: servicesubmenu; Caption: "${w_mysql}"; Service: ${c_mysqlService}; SubMenu: MySql
;Type: servicesubmenu; Caption: "${w_mariadb}"; Service: ${c_mariadbService}; SubMenu: MariaDb
Type: item; Caption: "${w_startServices}"; Action: multi; Actions: StartAll
Type: item; Caption: "${w_stopServices}"; Action: multi; Actions: StopAll
Type: item; Caption: "${w_restartServices}"; Action: multi; Actions: RestartAll
Type: separator;
${ItemPutOnline}Type: item; Caption: "${w_putOnline}"; Action: multi; Actions: onlineoffline
;Type: item; Caption: "For local test only"; Action: run; FileName: "${c_phpExe}"; Parameters: "test.php";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated; Glyph: 9
;WAMPMENULEFTEND

[apacheMenu]
;WAMPAPACHEMENUSTART
Type: submenu; Caption: "${w_version}"; SubMenu: apacheVersion; Glyph: 3
Type: submenu; Caption: "${w_service}"; SubMenu: apacheService; Glyph: 3
Type: submenu; Caption: "${w_apacheModules}"; SubMenu: apache_mod; Glyph: 25
Type: submenu; Caption: "${w_aliasDirectories}"; SubMenu: alias_dir; Glyph: 3
Type: item; Caption: "httpd.conf"; Glyph: 33; Action: run; FileName: "${c_editor}"; parameters: "${c_apacheConfFile}"
${EditVhostConf}Type: item; Caption: "httpd-vhosts.conf"; Glyph: 33; Action: run; Filename: "${c_editor}"; parameters: "${c_apacheVhostConfFile}"
Type: item; Caption: "${w_apacheErrorLog}"; Glyph: 33; Action: run; FileName: "${c_editor}"; parameters: "${c_installDir}/${logDir}apache_error.log"
Type: item; Caption: "${w_apacheAccessLog}"; Glyph: 33; Action: run; FileName: "${c_editor}"; parameters: "${c_installDir}/${logDir}access.log"
${ApaTestPortUsed}Type: separator; Caption: "${w_portUsed}${c_UsedPort}"
${ApaTestPortUsed}Type: item; Caption: "${w_testPort80}"; Action: run; FileName: "${c_phpExe}"; Parameters: "-c . testPort.php 80 ${c_apacheService}";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated; Glyph: 24
${ApaTestPortUsed}Type: item; Caption: "${w_AlternatePort}"; Action: multi; Actions: UseAlternatePort; Glyph: 24
${ApaTestPortUsed}Type: item; Caption: "${w_testPortUsed}${c_UsedPort}"; Action: run; FileName: "${c_phpExe}"; Parameters: "-c . testPort.php ${c_UsedPort} ${c_apacheService}";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated; Glyph: 24
;WAMPAPACHEMENUEND

[apacheVersion]
;WAMPAPACHEVERSIONSTART
;WAMPAPACHEVERSIONEND

[phpMenu]
;WAMPPHPMENUSTART
Type: submenu; Caption: "${w_version}"; SubMenu: phpVersion; Glyph: 3
Type: submenu; Caption: "${w_phpSettings}"; SubMenu: php_params; Glyph: 25
Type: submenu; Caption: "${w_phpExtensions}"; SubMenu: php_ext; Glyph: 25
Type: item; Caption: "php.ini"; Glyph: 33; Action: run; FileName: "${c_editor}"; parameters: "${c_phpConfFile}"
Type: item; Caption: "${w_phpLog}"; Glyph: 33; Action: run; FileName: "${c_editor}"; parameters: "${c_installDir}/${logDir}php_error.log"
;WAMPPHPMENUEND

[phpVersion]
;WAMPPHPVERSIONSTART
;WAMPPHPVERSIONEND

[mysqlMenu]
;WAMPMYSQLMENUSTART
Type: submenu; Caption: "${w_version}"; SubMenu: mysqlVersion; Glyph: 3
Type: submenu; Caption: "${w_service}"; SubMenu: mysqlService; Glyph: 3
Type: submenu; Caption: "${w_mysqlSettings}"; SubMenu: mysql_params; Glyph: 25
Type: item; Caption: "${w_mysqlConsole}"; Action: run; FileName: "${c_mysqlConsole}"; Parameters: "-u root -p"; Glyph: 0
Type: item; Caption: "my.ini"; Glyph: 33; Action: run; FileName: "${c_editor}"; parameters: "${c_mysqlConfFile}"
Type: item; Caption: "${w_mysqlLog}"; Glyph: 33; Action: run; FileName: "${c_editor}"; parameters: "${c_installDir}/${logDir}mysql.log"
${MysqlTestPortUsed}Type: separator; Caption: "${w_portUsedMysql}${c_UsedMysqlPort}"
${MysqlTestPortUsed}Type: item; Caption: "${w_testPortMysql}"; Action: run; FileName: "${c_phpExe}"; Parameters: "-c . testPort.php ${c_UsedMysqlPort} ${c_mysqlService}";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated; Glyph: 24
${MysqlTestPortUsed}Type: item; Caption: "${w_AlternateMysqlPort}"; Action: multi; Actions: UseAlternateMysqlPort; Glyph: 24
${MysqlTestPortUsed}Type: item; Caption: "${w_testPortMysqlUsed}${c_UsedMysqlPort}"; Action: run; FileName: "${c_phpExe}"; Parameters: "testPort.php ${c_UsedMysqlPort} ${c_mysqlService}";WorkingDir: "$c_installDir/scripts"; Flags: waituntilterminated; Glyph: 24
;WAMPMYSQLMENUEND

[mysqlVersion]
;WAMPMYSQLVERSIONSTART
;WAMPMYSQLVERSIONEND

[mysql_params]
Type: separator; Caption: "${w_mysqlSettings}"
;WAMPMYSQL_PARAMSSTART
;WAMPMYSQL_PARAMSEND

[mariadbMenu]
;WAMPMARIADBMENUSTART
Type: submenu; Caption: "${w_version}"; SubMenu: mariadbVersion; Glyph: 3
Type: submenu; Caption: "${w_service}"; SubMenu: mariadbService; Glyph: 3
Type: item; Caption: "${w_mariadbConsole}"; Action: run; FileName: "${c_mariadbConsole}"; Parameters: "-u root -p"; Glyph: 0
Type: item; Caption: "my.ini"; Glyph: 6; Action: run; FileName: "${c_editor}"; parameters: "${c_mariadbConfFile}"
Type: item; Caption: "${w_mariadbLog}"; Glyph: 6; Action: run; FileName: "${c_editor}"; parameters: "${c_installDir}/${logDir}mariadb.log"
Type: separator; Caption: "${w_portUsedMariadb}${c_UsedMariadbPort}"
Type: item; Caption: "${w_testPortMariadb}"; Action: run; FileName: "${c_phpExe}"; Parameters: "-c . testPort.php ${c_UsedMariadbPort} ${c_mariadbService}";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated; Glyph: 9
Type: item; Caption: "${w_AlternateMariadbPort}"; Action: multi; Actions: UseAlternateMariadbPort; Glyph: 9
;WAMPMARIADBMENUEND

[mariadbVersion]
;WAMPMARIADBVERSIONSTART
;WAMPMARIADBVERSIONEND

[alias_dir]
;WAMPALIAS_DIRSTART
Type: separator; Caption: "${w_aliasDirectories}"
Type: item; Caption: "${w_addAlias}"; Action: multi; Actions: add_alias; Glyph: 34
Type: separator
;WAMPADDALIAS
;WAMPALIAS_DIREND


[php_params]
Type: separator; Caption: "${w_phpSettings}"
;WAMPPHP_PARAMSSTART
;WAMPPHP_PARAMSEND


[php_ext]
Type: separator; Caption: "${w_phpExtensions}"
;WAMPPHP_EXTSTART
;WAMPPHP_EXTEND


[add_alias]
;WAMPADD_ALIASSTART
Action: run; FileName: "${c_phpExe}"; Parameters: "-c . addAlias.php";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated
Action: run; FileName: "${c_phpCli}"; Parameters: "refresh.php";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated
Action: service; Service: ${c_apacheService}; ServiceAction: restart;
Action: resetservices
Action: readconfig;
;WAMPADD_ALIASEND


[DoubleClickAction]
Action: about;

[apacheService]
;WAMPAPACHESERVICESTART
Type: separator; Caption: "${w_apache}"
Type: item; Caption: "${w_startResume}"; Action: service; Service: ${c_apacheService}; ServiceAction: startresume; Glyph: 9
;Type: item; Caption: "${w_pauseService}"; Action: service; Service: ${c_apacheService}; ServiceAction: pause; Glyph: 10
Type: item; Caption: "${w_stopService}"; Action: service; Service: ${c_apacheService}; ServiceAction: stop; Glyph: 11
Type: item; Caption: "${w_restartService}"; Action: service; Service: ${c_apacheService}; ServiceAction: restart; Glyph: 12
Type: separator
Type: item; Caption: "${w_installService}"; Action: multi; Actions: ApacheServiceInstall; Glyph: 8
Type: item; Caption: "${w_removeService}"; Action: multi; Actions: ApacheServiceRemove; Glyph: 7
;WAMPAPACHESERVICEEND


[MySqlService]
;WAMPMYSQLSERVICESTART
Type: separator; Caption: "${w_mysql}"
Type: item; Caption: "${w_startResume}"; Action: service; Service: ${c_mysqlService}; ServiceAction: startresume; Glyph: 9; Flags: ignoreerrors
;Type: item; Caption: "${w_pauseService}"; Action: service; Service: mysql; ServiceAction: pause; Glyph: 10
Type: item; Caption: "${w_stopService}"; Action: service; Service: ${c_mysqlService}; ServiceAction: stop; Glyph: 11
Type: item; Caption: "${w_restartService}"; Action: service; Service: ${c_mysqlService}; ServiceAction: restart; Glyph: 12
Type: separator
Type: item; Caption: "${w_installService}"; Action: multi; Actions: MySQLServiceInstall; Glyph: 8
Type: item; Caption: "${w_removeService}"; Action: multi; Actions: MySQLServiceRemove; Glyph: 7
;WAMPMYSQLSERVICEEND


[MariaDbService]
;WAMPMARIADBSERVICESTART
Type: separator; Caption: "${w_mariadb}"
Type: item; Caption: "${w_startResume}"; Action: service; Service: ${c_mariadbService}; ServiceAction: startresume; Glyph: 9; Flags: ignoreerrors
;Type: item; Caption: "${w_pauseService}"; Action: service; Service: mariadb; ServiceAction: pause; Glyph: 10
Type: item; Caption: "${w_stopService}"; Action: service; Service: ${c_mariadbService}; ServiceAction: stop; Glyph: 11
Type: item; Caption: "${w_restartService}"; Action: service; Service: ${c_mariadbService}; ServiceAction: restart; Glyph: 12
Type: separator
Type: item; Caption: "${w_installService}"; Action: multi; Actions: MariaDBServiceInstall; Glyph: 8
Type: item; Caption: "${w_removeService}"; Action: multi; Actions: MariaDBServiceRemove; Glyph: 7
;WAMPMARIADBSERVICEEND


[StartAll]
;WAMPSTARTALLSTART
Action: service; Service: ${c_apacheService}; ServiceAction: startresume; Flags: ignoreerrors
Action: service; Service: ${c_mysqlService}; ServiceAction: startresume; Flags: ignoreerrors
Action: service; Service: ${c_mariadbService}; ServiceAction: startresume; Flags: ignoreerrors
;WAMPSTARTALLEND

[StopAll]
;WAMPSTOPALLSTART
Action: service; Service: ${c_apacheService}; ServiceAction: stop; Flags: ignoreerrors
Action: service; Service: ${c_mysqlService}; ServiceAction: stop; Flags: ignoreerrors
Action: service; Service: ${c_mariadbService}; ServiceAction: stop; Flags: ignoreerrors
;WAMPSTOPALLEND

[RestartAll]
;WAMPRESTARTALLSTART
Action: service; Service: ${c_apacheService}; ServiceAction: stop; Flags: ignoreerrors waituntilterminated
Action: service; Service: ${c_mysqlService}; ServiceAction: stop; Flags: ignoreerrors waituntilterminated
Action: service; Service: ${c_mariadbService}; ServiceAction: stop; Flags: ignoreerrors waituntilterminated
Action: service; Service: ${c_apacheService}; ServiceAction: startresume; Flags: ignoreerrors waituntilterminated
Action: service; Service: ${c_mysqlService}; ServiceAction: startresume; Flags: ignoreerrors waituntilterminated
Action: service; Service: ${c_mariadbService}; ServiceAction: startresume; Flags: ignoreerrors waituntilterminated
;WAMPRESTARTALLEND

[myexit]
;WAMPMYEXITSTART
Action: service; Service: ${c_apacheService}; ServiceAction: stop; Flags: ignoreerrors
Action: service; Service: ${c_mysqlService}; ServiceAction: stop; Flags: ignoreerrors
Action: service; Service: ${c_mariadbService}; ServiceAction: stop; Flags: ignoreerrors
Action: exit
;WAMPMYEXITEND

[apache_mod]
;WAMPAPACHE_MODSTART
;WAMPAPACHE_MODEND


[ApacheServiceInstall]
;WAMPAPACHESERVICEINSTALLSTART
Action: run; FileName: "${c_phpExe}"; Parameters: "-c . testPortForInstall.php";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated
Action: run; FileName: "${c_apacheExe}"; Parameters: "${c_apacheServiceInstallParams}"; ShowCmd: hidden; Flags: waituntilterminated
Action: run; Filename: "sc"; Parameters: "\\\\. config ${c_apacheService} start= demand"; ShowCmd: hidden; Flags: waituntilterminated
Action: resetservices
Action: readconfig;
;WAMPAPACHESERVICEINSTALLEND


[ApacheServiceRemove]
;WAMPAPACHESERVICEREMOVESTART
Action: service; Service: ${c_apacheService}; ServiceAction: stop; Flags: ignoreerrors waituntilterminated
Action: run; FileName: "${c_apacheExe}"; Parameters: "${c_apacheServiceRemoveParams}"; ShowCmd: hidden; Flags: waituntilterminated
Action: resetservices
Action: readconfig;
;WAMPAPACHESERVICEREMOVEEND

[UseAlternatePort]
;WAMPALTERNATEPORTSTART
Action: service; Service: ${c_apacheService}; ServiceAction: stop; Flags: ignoreerrors waituntilterminated
Action: run; FileName: "${c_phpExe}"; Parameters: "-c . switchWampPort.php %ApachePort%";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated
Action: service; Service: ${c_apacheService}; ServiceAction: startresume; Flags: ignoreerrors waituntilterminated
Action: run; FileName: "${c_phpCli}"; Parameters: "refresh.php";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated
Action: readconfig;
;WAMPALTERNATEPORTEND

[UseAlternateMysqlPort]
;WAMPALTERNATEMYSQLPORTSTART
Action: service; Service: ${c_apacheService}; ServiceAction: stop; Flags: ignoreerrors waituntilterminated
Action: service; Service: ${c_mysqlService}; ServiceAction: stop; Flags: ignoreerrors waituntilterminated
Action: run; FileName: "${c_phpExe}"; Parameters: "-c . switchMysqlPort.php %MysqlPort%";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated
Action: service; Service: ${c_apacheService}; ServiceAction: startresume; Flags: ignoreerrors waituntilterminated
Action: service; Service: ${c_mysqlService}; ServiceAction: startresume; Flags: ignoreerrors waituntilterminated
Action: run; FileName: "${c_phpCli}"; Parameters: "refresh.php";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated
Action: readconfig;
;WAMPALTERNATEMYSQLPORTEND

[MySQLServiceInstall]
;WAMPMYSQLSERVICEINSTALLSTART
Action: run; FileName: "${c_mysqlExe}"; Parameters: "${c_mysqlServiceInstallParams}"; ShowCmd: hidden; Flags: ignoreerrors waituntilterminated
Action: resetservices;
Action: readconfig;
;WAMPMYSQLSERVICEINSTALLEND

[MySQLServiceRemove]
;WAMPMYSQLSERVICEREMOVESTART
Action: service; Service: ${c_mysqlService}; ServiceAction: stop; Flags: ignoreerrors waituntilterminated
Action: run; FileName: "${c_mysqlExe}"; Parameters: "${c_mysqlServiceRemoveParams}"; ShowCmd: hidden; Flags: waituntilterminated
Action: resetservices;
Action: readconfig;
;WAMPMYSQLSERVICEREMOVEEND

[UseAlternateMariadbPort]
;WAMPALTERNATEMARIADBPORTSTART
Action: service; Service: ${c_apacheService}; ServiceAction: stop; Flags: ignoreerrors waituntilterminated
Action: service; Service: ${c_mariadbService}; ServiceAction: stop; Flags: ignoreerrors waituntilterminated
Action: run; FileName: "${c_phpExe}"; Parameters: "-c . switchMysqlPort.php %MysqlPort%";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated
Action: service; Service: ${c_apacheService}; ServiceAction: startresume; Flags: ignoreerrors waituntilterminated
Action: service; Service: ${c_mariadbService}; ServiceAction: startresume; Flags: ignoreerrors waituntilterminated
Action: run; FileName: "${c_phpCli}"; Parameters: "refresh.php";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated
Action: readconfig;
;WAMPALTERNATEMARIADBPORTEND

[MariaDBServiceInstall]
;WAMPMARIADBSERVICEINSTALLSTART
Action: run; FileName: "${c_mariadbExe}"; Parameters: "${c_mariadbServiceInstallParams}"; ShowCmd: hidden; Flags: ignoreerrors waituntilterminated
Action: resetservices;
Action: readconfig;
;WAMPMARIADBSERVICEINSTALLEND

[MariaDBServiceRemove]
;WAMPMARIADBSERVICEREMOVESTART
Action: service; Service: ${c_mariadbService}; ServiceAction: stop; Flags: ignoreerrors waituntilterminated
Action: run; FileName: "${c_mariadbExe}"; Parameters: "${c_mariadbServiceRemoveParams}"; ShowCmd: hidden; Flags: waituntilterminated
Action: resetservices;
Action: readconfig;
;WAMPMARIADBSERVICEREMOVEEND

[submenu.tools]
;WAMPTOOLSSTART
Type: Separator; Caption: "${w_wampTools}"
Type: item; Caption: "${w_restartDNS}"; Action: multi; Actions: DnscacheServiceRestart; Glyph: 24
Type: item; Caption: "${w_testConf}"; Action: run; FileName: "${c_apacheExe}"; Parameters: "-t -w"; Flags: waituntilterminated; Glyph: 24
Type: item; Caption: "${w_testServices}"; Action: run; FileName: "${c_phpExe}"; Parameters: "msg.php stateservices";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated; Glyph: 24
Type: item; Caption: "${w_dnsorder}"; Action: run; FileName: "${c_phpExe}"; Parameters: "msg.php dnsorder";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated; Glyph: 24
Type: item; Caption: "${w_compilerVersions}"; Action: run; FileName: "${c_phpExe}"; Parameters: "msg.php compilerversions";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated; Glyph: 24
Type: item; Caption: "${w_vhostConfig}"; Action: run; FileName: "${c_phpExe}"; Parameters: "msg.php vhostconfig";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated; Glyph: 24
Type: item; Caption: "${w_apacheLoadedModules}"; Action: run; FileName: "${c_phpExe}"; Parameters: "msg.php apachemodules";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated; Glyph: 24
;Type: item; Caption: "Gestionnaire des services/Services Control Panel"; Action: controlpanelservices; Glyph: 24
Type: submenu; Caption: "${w_deleteVer}"; Submenu: DeleteOldVersions; Glyph: 26
Type: separator; Caption: "${w_portUsed}${c_UsedPort}"
Type: item; Caption: "${w_testPort80}"; Action: run; FileName: "${c_phpExe}"; Parameters: "-c . testPort.php 80 ${c_apacheService}";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated; Glyph: 24
Type: item; Caption: "${w_AlternatePort}"; Action: multi; Actions: UseAlternatePort; Glyph: 24
${ApaTestPortUsed}Type: item; Caption: "${w_testPortUsed}${c_UsedPort}"; Action: run; FileName: "${c_phpExe}"; Parameters: "-c . testPort.php ${c_UsedPort} ${c_apacheService}";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated; Glyph: 24
Type: separator; Caption: "${w_portUsedMysql}${c_UsedMysqlPort}"
;Type: item; Caption: "${w_testPortMysqlUsed}${c_UsedMysqlPort}"; Action: run; FileName: "${c_phpExe}"; Parameters: "-c . testPort.php ${c_UsedMysqlPort} ${c_mysqlService}";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated; Glyph: 24
${MysqlTestPortUsed}Type: item; Caption: "${w_AlternateMysqlPort}"; Action: multi; Actions: UseAlternateMysqlPort; Glyph: 24
Type: separator; Caption: "${w_portUsedMariadb}${c_UsedMariadbPort}"
;Type: item; Caption: "${w_testPortMariadbUsed}${c_UsedMariadbPort}"; Action: run; FileName: "${c_phpExe}"; Parameters: "-c . testPort.php ${c_UsedMariadbPort} ${c_mariadbService}";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated; Glyph: 24
Type: item; Caption: "${w_AlternateMariadbPort}"; Action: multi; Actions: UseAlternateMariadbPort; Glyph: 24
Type: separator; Caption: "- Apache: ${c_apacheService} -"
Type: separator; Caption: "- MySQL: ${c_mysqlService} -"
Type: separator; Caption: "- MariaDB: ${c_mariadbService} -"
${ItemChangeServiceNames}Type: item; Caption: "${w_changeServices}"; Action: multi; Actions: changeservicesnames; Glyph: 24
Type: separator; Caption: "${w_empty} logs"
Type: item; Caption: "${w_empty} ${w_phpLog}"; Action: run; FileName: "${c_phpExe}"; parameters: "-c . msg.php refreshLogs ${c_installDir}/${logDir}php_error.log";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated; Glyph: 32
Type: item; Caption: "${w_empty} ${w_apacheErrorLog}"; Action: run; FileName: "${c_phpExe}"; parameters: "-c . msg.php refreshLogs ${c_installDir}/${logDir}apache_error.log";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated; Glyph: 32
Type: item; Caption: "${w_empty} ${w_apacheAccessLog}"; Action: run; FileName: "${c_phpExe}"; parameters: "-c . msg.php refreshLogs ${c_installDir}/${logDir}access.log";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated; Glyph: 32
Type: item; Caption: "${w_empty} ${w_mysqlLog}"; Action: run; FileName: "${c_phpExe}"; parameters: "-c . msg.php refreshLogs ${c_installDir}/${logDir}mysql.log";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated; Glyph: 32
Type: item; Caption: "${w_empty} ${w_mariadbLog}"; Action: run; FileName: "${c_phpExe}"; parameters: "-c . msg.php refreshLogs ${c_installDir}/${logDir}mariadb.log";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated; Glyph: 32
Type: item; Caption: "${w_emptyAll} ${w_logFiles}"; Action: run; FileName: "${c_phpExe}"; parameters: "-c . msg.php refreshLogs ${c_installDir}/${logDir}php_error.log ${c_installDir}/${logDir}apache_error.log ${c_installDir}/${logDir}access.log ${c_installDir}/${logDir}mysql.log ${c_installDir}/${logDir}mariadb.log";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated; Glyph: 32
;WAMPTOOLSEND

[DnscacheServiceRestart]
;WAMPDNSCACHESERVICESTART
Action: service; Service: ${c_apacheService}; ServiceAction: stop; Flags: ignoreerrors waituntilterminated
Action: run; Filename: "ipconfig"; Parameters: "/flushdns"; ShowCmd: hidden; Flags: waituntilterminated
Action: run; Filename: "net"; Parameters: "stop dnscache"; ShowCmd: hidden; Flags: waituntilterminated
Action: run; Filename: "net"; Parameters: "start dnscache"; ShowCmd: hidden; Flags: waituntilterminated
Action: run; FileName: "net"; Parameters: "start ${c_apacheService}"; ShowCmd: hidden; Flags: waituntilterminated
Action: run; FileName: "${c_phpCli}"; Parameters: "refresh.php"; WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated
Action: resetservices
Action: readconfig;
;WAMPDNSCACHESERVICEEND

[DeleteOldVersions]
;WAMPDELETEOLDVERSIONSSTART
;WAMPDELETEOLDVERSIONSEND


[onlineoffline]
;WAMPONLINEOFFLINESTART
Action: run; FileName: "${c_phpExe}"; Parameters: "-c . onlineOffline.php on";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated
Action: run; FileName: "${c_phpCli}"; Parameters: "refresh.php";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated
Action: service; Service: ${c_apacheService}; ServiceAction: restart;
Action: resetservices;
Action: readconfig;
;WAMPONLINEOFFLINEEND

[changeservicesnames]
;WAMPCHANGESERVICESSTART
Action: service; Service: ${c_apacheService}; ServiceAction: stop; Flags: ignoreerrors waituntilterminated
Action: run; FileName: "${c_apacheExe}"; Parameters: "${c_apacheServiceRemoveParams}"; ShowCmd: hidden; Flags: waituntilterminated
Action: service; Service: ${c_mysqlService}; ServiceAction: stop; Flags: ignoreerrors waituntilterminated
Action: run; FileName: "${c_mysqlExe}"; Parameters: "${c_mysqlServiceRemoveParams}"; ShowCmd: hidden; Flags: waituntilterminated
Action: service; Service: ${c_mariadbService}; ServiceAction: stop; Flags: ignoreerrors waituntilterminated
Action: run; FileName: "${c_mariadbExe}"; Parameters: "${c_mariadbServiceRemoveParams}"; ShowCmd: hidden; Flags: waituntilterminated
Action: closeservices;
Action: run; FileName: "${c_phpCli}"; Parameters: "switchServicesNames.php %ApacheService% %MysqlService% %MariadbService%";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated
Action: run; FileName: "${c_phpExe}"; Parameters: "msg.php changeServiceName";WorkingDir: "${c_installDir}/scripts"; Flags: waituntilterminated
Action: exit;
;WAMPCHANGESERVICESEND

EOTPL;

?>