REM for initialize data folder mysql 5.7.*
REM use this command line
mysqld --initialize-insecure

REM start server with specific config file
mysqld --defaults-file=my.ini

--------------------------------------

:: for mysql
CREATE USER IF NOT EXISTS 'phlyper'@'localhost' IDENTIFIED BY 'azerty';
GRANT ALL PRIVILEGES ON *.* TO 'phlyper'@'localhost' WITH GRANT OPTION;

:: for mariadb
CREATE USER IF NOT EXISTS 'phlyper'@'localhost' IDENTIFIED BY 'azerty';
GRANT ALL PRIVILEGES ON  *.* to 'phlyper'@'localhost' WITH GRANT OPTION;


FLUSH PRIVILEGES;
--------------------------------------

REM upgrade shutdown mysql server

mysqlcheck –all-databases –check-upgrade –auto-repair
mysql < fix_priv_tables
mysqlcheck –all-databases –check-upgrade –auto-repair –fix-db-names –fix-table-names

mysql_upgrade -h <host> -P <port> -u <mysqluser> -p<password>

--------------------------------------

REM shutdown mysql server

mysqladmin -h <host> -P <port> -u <mysqluser> -p<password> shutdown

--------------------------------------

SELECT @@GLOBAL.sql_mode;
SELECT @@SESSION.sql_mode;

SET GLOBAL sql_mode = 'modes';
SET SESSION sql_mode = 'modes';

REM default value mysql 5.5.26 NO_ENGINE_SUBSTITUTION
REM default value mariadb 10.1.25 NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION


