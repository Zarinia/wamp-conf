SET "PATH_MC=C:\wamp\bin\mysql\mysql5.7.20"

cd %PATH_MC%

bin\mysqld --defaults-file=my-16.ini --initialize-insecure --console --explicit_defaults_for_timestamp
bin\mysqld --defaults-file=my-17.ini --initialize-insecure --console --explicit_defaults_for_timestamp
bin\mysqld --defaults-file=my-18.ini --initialize-insecure --console --explicit_defaults_for_timestamp
bin\mysqld --defaults-file=my-19.ini --initialize-insecure --console --explicit_defaults_for_timestamp

:: set config for any server
:: server_id = 2
:: gtid_mode=ON
:: enforce_gtid_consistency=ON
:: master_info_repository=TABLE
:: relay_log_info_repository=TABLE
:: binlog_checksum=NONE
:: log_slave_updates=ON
:: log-bin=mysql-bin
:: binlog_format=mixed
:: ; transaction_write_set_extraction=XXHASH64

bin\mysqld --defaults-file=my-16.ini --console
bin\mysqld --defaults-file=my-17.ini --console
bin\mysqld --defaults-file=my-18.ini --console
bin\mysqld --defaults-file=my-19.ini --console

:: CREATE USER innodb_user@'%' IDENTIFIED BY 'azerty';
:: GRANT ALL PRIVILEGES ON mysql_innodb_cluster_metadata.* TO innodb_user@'%' WITH GRANT OPTION;
:: GRANT RELOAD, SHUTDOWN, PROCESS, FILE, SUPER, REPLICATION SLAVE, REPLICATION CLIENT,  CREATE USER ON *.* TO innodb_user@'%' WITH GRANT OPTION;
:: GRANT SELECT ON *.* TO innodb_user@'%' WITH GRANT OPTION;
:: GRANT DELETE, INSERT, UPDATE ON *.* TO innodb_user@'%' WITH GRANT OPTION;
:: FLUSH privileges;

:: INSTALL PLUGIN group_replication SONAME 'group_replication.so'; # for linux
:: INSTALL PLUGIN group_replication SONAME 'group_replication.dll'; # for windows

:: mysqlsh --uri innodb_user@localhost:3316
:: var cluster = dba.createCluster('prodCluster');
:: cluster.addInstance('innodb_user@localhost:3317');




