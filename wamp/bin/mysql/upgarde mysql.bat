REM for initialize data folder mysql 5.7.*
REM use this command line
mysqld --initialize-insecure --console --explicit_defaults_for_timestamp
mysqld --defaults-file=my.ini --initialize-insecure --console

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

--------------------------------------

REM save current setting of sql_mode
SET @old_sql_mode := @@sql_mode ;

REM derive a new value by removing NO_ZERO_DATE and NO_ZERO_IN_DATE
SET @new_sql_mode := @old_sql_mode ;
SET @new_sql_mode := TRIM(BOTH ',' FROM REPLACE(CONCAT(',',@new_sql_mode,','),',NO_ZERO_DATE,'  ,','));
SET @new_sql_mode := TRIM(BOTH ',' FROM REPLACE(CONCAT(',',@new_sql_mode,','),',NO_ZERO_IN_DATE,',','));
SET @@sql_mode := @new_sql_mode ;

REM perform the operation that errors due to "zero dates"

REM when we are done with required operations, we can revert back
REM to the original sql_mode setting, from the value we saved
SET @@sql_mode := @old_sql_mode ;

SELECT @@sql_mode current_sql_mode, @old_sql_mode as old_sql_mode, @new_sql_mode as new_sql_mode;





