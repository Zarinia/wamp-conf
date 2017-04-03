REM for initialize data folder mysql 5.7.*
REM use this command line
mysqld --initialize-insecure

--------------------------------------

:: for mysql
CREATE USER IF NOT EXISTS phlyper IDENTIFIED BY 'azerty';
GRANT ALL PRIVILEGES ON *.* TO 'phlyper'@'localhost' WITH GRANT OPTION;

:: for mariadb
CREATE USER IF NOT EXISTS 'phlyper'@'localhost' IDENTIFIED BY 'azerty';
GRANT ALL PRIVILEGES ON  *.* to 'phlyper'@'localhost' WITH GRANT OPTION;

--------------------------------------

REM upgrade shutdown mysql server

mysqlcheck –all-databases –check-upgrade –auto-repair
mysql < fix_priv_tables
mysqlcheck –all-databases –check-upgrade –auto-repair –fix-db-names –fix-table-names

mysql_upgrade -h <host> p <port> -u <mysqluser> -p<password>

--------------------------------------

REM shutdown mysql server

mysqladmin shutdown -h <host> p <port> -u <mysqluser> -p<password>

