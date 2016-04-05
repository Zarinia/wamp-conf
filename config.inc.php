<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * phpMyAdmin sample configuration, you can use it as base for
 * manual configuration. For easier setup you can use setup/
 *
 * All directives are explained in documentation in the doc/ folder
 * or at <http://docs.phpmyadmin.net/>.
 *
 * @package PhpMyAdmin
 */

/**
 * This is needed for cookie based authentication to encrypt password in
 * cookie
 */
$cfg['blowfish_secret'] = 'wamp'; /* YOU MUST FILL IN THIS FOR COOKIE AUTH! */

/**
 * Servers configuration
 */
$i = 0;

/**
 * First server : MySQL
 */
$i++;
/* Authentication type */
$cfg['Servers'][$i]['auth_type'] = 'cookie';
// $cfg['Servers'][$i]['user']          = 'phlyper';      // MySQL user
// $cfg['Servers'][$i]['password']      = 'azerty';          // MySQL password (only needed)
/* Server parameters */
$cfg['Servers'][$i]['verbose'] = 'localhost MySQL port 3306';
$cfg['Servers'][$i]['host'] = 'localhost';
$cfg['Servers'][$i]['port'] = '3306';
$cfg['Servers'][$i]['connect_type'] = 'tcp';
$cfg['Servers'][$i]['compress'] = false;
/* Select mysql if your server does not have mysqli */
$cfg['Servers'][$i]['extension'] = 'mysqli';
$cfg['Servers'][$i]['AllowNoPassword'] = false;

// Hidden databases in PhpMyAdmin left panel
// $cfg['Servers'][$i]['hide_db'] = '(information_schema|mysql|performance_schema|sys)';

// Suppress Warning about pmadb tables
// $cfg['PmaNoRelation_DisableWarning'] = true;

/*
 * phpMyAdmin configuration storage settings.
 */

/* User used to manipulate with storage */
// $cfg['Servers'][$i]['controlhost'] = '';
// $cfg['Servers'][$i]['controlport'] = '';
$cfg['Servers'][$i]['controluser'] = 'pma';
$cfg['Servers'][$i]['controlpass'] = '';

/* Storage database and tables */
$cfg['Servers'][$i]['pmadb'] = 'phpmyadmin';
$cfg['Servers'][$i]['bookmarktable'] = 'pma__bookmark';
$cfg['Servers'][$i]['relation'] = 'pma__relation';
$cfg['Servers'][$i]['table_info'] = 'pma__table_info';
$cfg['Servers'][$i]['table_coords'] = 'pma__table_coords';
$cfg['Servers'][$i]['pdf_pages'] = 'pma__pdf_pages';
$cfg['Servers'][$i]['column_info'] = 'pma__column_info';
$cfg['Servers'][$i]['history'] = 'pma__history';
$cfg['Servers'][$i]['table_uiprefs'] = 'pma__table_uiprefs';
$cfg['Servers'][$i]['tracking'] = 'pma__tracking';
$cfg['Servers'][$i]['userconfig'] = 'pma__userconfig';
$cfg['Servers'][$i]['recent'] = 'pma__recent';
$cfg['Servers'][$i]['favorite'] = 'pma__favorite';
$cfg['Servers'][$i]['users'] = 'pma__users';
$cfg['Servers'][$i]['usergroups'] = 'pma__usergroups';
$cfg['Servers'][$i]['navigationhiding'] = 'pma__navigationhiding';
$cfg['Servers'][$i]['savedsearches'] = 'pma__savedsearches';
$cfg['Servers'][$i]['central_columns'] = 'pma__central_columns';
$cfg['Servers'][$i]['designer_settings'] = 'pma__designer_settings';
$cfg['Servers'][$i]['export_templates'] = 'pma__export_templates';
/* Contrib / Swekey authentication */
// $cfg['Servers'][$i]['auth_swekey_config'] = '/etc/swekey-pma.conf';

/**
 * Second server : MariaDB
 */
$i++;
/* Authentication type */
$cfg['Servers'][$i]['auth_type'] = 'cookie';
// $cfg['Servers'][$i]['user']          = 'phlyper';      // MySQL user

// $cfg['Servers'][$i]['password']      = 'azerty';          // MySQL password (only needed)
/* Server parameters */
$cfg['Servers'][$i]['verbose'] = 'localhost MariaDB port 3307';
$cfg['Servers'][$i]['host'] = 'localhost';
$cfg['Servers'][$i]['port'] = '3307';
$cfg['Servers'][$i]['connect_type'] = 'tcp';
$cfg['Servers'][$i]['compress'] = false;
/* Select mysql if your server does not have mysqli */
$cfg['Servers'][$i]['extension'] = 'mysqli';
$cfg['Servers'][$i]['AllowNoPassword'] = false;

// Hidden databases in PhpMyAdmin left panel
// $cfg['Servers'][$i]['hide_db'] = '(information_schema|mysql|performance_schema|sys)';

// Suppress Warning about pmadb tables
// $cfg['PmaNoRelation_DisableWarning'] = true;

/*
 * phpMyAdmin configuration storage settings.
 */

/* User used to manipulate with storage */
// $cfg['Servers'][$i]['controlhost'] = '';
// $cfg['Servers'][$i]['controlport'] = '';
$cfg['Servers'][$i]['controluser'] = 'pma';
$cfg['Servers'][$i]['controlpass'] = '';

/* Storage database and tables */
$cfg['Servers'][$i]['pmadb'] = 'phpmyadmin';
$cfg['Servers'][$i]['bookmarktable'] = 'pma__bookmark';
$cfg['Servers'][$i]['relation'] = 'pma__relation';
$cfg['Servers'][$i]['table_info'] = 'pma__table_info';
$cfg['Servers'][$i]['table_coords'] = 'pma__table_coords';
$cfg['Servers'][$i]['pdf_pages'] = 'pma__pdf_pages';
$cfg['Servers'][$i]['column_info'] = 'pma__column_info';
$cfg['Servers'][$i]['history'] = 'pma__history';
$cfg['Servers'][$i]['table_uiprefs'] = 'pma__table_uiprefs';
$cfg['Servers'][$i]['tracking'] = 'pma__tracking';
$cfg['Servers'][$i]['userconfig'] = 'pma__userconfig';
$cfg['Servers'][$i]['recent'] = 'pma__recent';
$cfg['Servers'][$i]['favorite'] = 'pma__favorite';
$cfg['Servers'][$i]['users'] = 'pma__users';
$cfg['Servers'][$i]['usergroups'] = 'pma__usergroups';
$cfg['Servers'][$i]['navigationhiding'] = 'pma__navigationhiding';
$cfg['Servers'][$i]['savedsearches'] = 'pma__savedsearches';
$cfg['Servers'][$i]['central_columns'] = 'pma__central_columns';
$cfg['Servers'][$i]['designer_settings'] = 'pma__designer_settings';
$cfg['Servers'][$i]['export_templates'] = 'pma__export_templates';
/* Contrib / Swekey authentication */
// $cfg['Servers'][$i]['auth_swekey_config'] = '/etc/swekey-pma.conf';

/**
 * End of servers configuration
 */

$cfg['DefaultConnectionCollation'] = 'utf8_general_ci';
$cfg['ServerDefault'] = stripos($_SERVER["HTTP_HOST"], 'mariadb') !== false ? 2 : 1;
$cfg['ShowPhpInfo'] = true;
//$cfg['ThemeDefault'] = 'metro';
# Debug
#$cfg['DBG']['sql'] = true;
#$cfg['DBG']['demo'] = true;
#$cfg['Error_Handler']['display'] = true;
# Lien vers la documentation francophone
$cfg['MySQLManualBase'] = 'http://dev.mysql.com/doc/refman/5.0/fr/';
$cfg['MySQLManualBase'] = 'http://dev.mysql.com/doc/refman/5.6/en/';

/**
  * Type:	integer [number of seconds]
  * Default value:	1440
  * Define how long a login cookie is valid. Please note that php configuration option session.gc_maxlifetime might limit session validity and if the session is lost, the login cookie is also invalidated. So it is a good idea to set session.gc_maxlifetime at least to the same value of $cfg['LoginCookieValidity'].
  */
ini_set('session.gc_maxlifetime', 14400);
$cfg['LoginCookieValidity'] = 14400;

/**
 * The maximum number of recently used tables shown in the left navigation frame.
 * Set this to 0 (zero) to disable the listing of recent tables. 
 */
// $cfg['LeftRecentTable'] = 10;
 
/**
 * Directories for saving/loading files from server
 */
$cfg['UploadDir'] = '';
$cfg['SaveDir'] = '';

/**
 * Whether to display icons or text or both icons and text in table row
 * action segment. Value can be either of 'icons', 'text' or 'both'.
 * default = 'both'
 */
// $cfg['RowActionType'] = 'icons';

/**
 * Defines whether a user should be displayed a "show all (records)"
 * button in browse mode or not.
 * default = false
 */
$cfg['ShowAll'] = true;

/**
 * Number of rows displayed when browsing a result set. If the result
 * set contains more rows, "Previous" and "Next".
 * Possible values: 25, 50, 100, 250, 500
 * default = 25
 */
$cfg['MaxRows'] = 50;

/**
 * Disallow editing of binary fields
 * valid values are:
 *   false    allow editing
 *   'blob'   allow editing except for BLOB fields
 *   'noblob' disallow editing except for BLOB fields
 *   'all'    disallow editing
 * default = 'blob'
 */
// $cfg['ProtectBinary'] = false;

/**
 * Default language to use, if not browser-defined or user-defined
 * (you find all languages in the locale folder)
 * uncomment the desired line:
 * default = 'en'
 */
// $cfg['DefaultLang'] = 'en';
// $cfg['DefaultLang'] = 'de';
$cfg['DefaultLang'] = 'fr';

/**
 * How many columns should be used for table display of a database?
 * (a value larger than 1 results in some information being hidden)
 * default = 1
 */
// $cfg['PropertiesNumColumns'] = 2;

/**
 * Set to true if you want DB-based query history.If false, this utilizes
 * JS-routines to display query history (lost by window close)
 *
 * This requires configuration storage enabled, see above.
 * default = false
 */
$cfg['QueryHistoryDB'] = true;

/**
 * When using DB-based query history, how many entries should be kept?
 * default = 25
 */
// $cfg['QueryHistoryMax'] = 100;

/**
 * Whether or not to query the user before sending the error report to
 * the phpMyAdmin team when a JavaScript error occurs
 *
 * Available options
 * ('ask' | 'always' | 'never')
 * default = 'ask'
 */
//$cfg['SendErrorReports'] = 'always';

/**
 * You can find more configuration options in the documentation
 * in the doc/ folder or at <http://docs.phpmyadmin.net/>.
 */

$cfg['ExecTimeLimit'] = 0;
$cfg['PersistentConnections'] = true;

?>
