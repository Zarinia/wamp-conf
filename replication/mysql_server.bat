cd E:\xampp\

:: MASTER
E:\xampp\mysql_master\bin\mysqld.exe --install xamppmysqlmaster --defaults-file=E:\xampp\mysql_master\my.ini
sc config xamppmysqlmaster start=manual
sc config xamppmysqlmaster start=disabled
sc config xamppmysqlmaster start=auto
net start xamppmysqlmaster
net stop xamppmysqlmaster
sc delete xamppmysqlmaster


:: SLAVE
E:\xampp\mysql_slave\bin\mysqld.exe --install xamppmysqlslave --defaults-file=E:\xampp\mysql_slave\my.ini
sc config xamppmysqlslave start=manual
sc config xamppmysqlslave start=disabled
sc config xamppmysqlslave start=auto
net start xamppmysqlslave
net stop xamppmysqlslave
sc delete xamppmysqlslave



:: for run mysql server
mysqld
:: for shutdown mysql server
mysqladmin -u root shutdown

:: -------------------------------------------------------------

:: for run 4 master services
start "Mysql Server localhost 3316" E:\xampp\mysql_master\bin\mysqld.exe --defaults-file=E:\xampp\mysql_master\my_3316.ini
start "Mysql Server localhost 3317" E:\xampp\mysql_master\bin\mysqld.exe --defaults-file=E:\xampp\mysql_master\my_3317.ini
start "Mysql Server localhost 3318" E:\xampp\mysql_master\bin\mysqld.exe --defaults-file=E:\xampp\mysql_master\my_3318.ini
start "Mysql Server localhost 3319" E:\xampp\mysql_master\bin\mysqld.exe --defaults-file=E:\xampp\mysql_master\my_3319.ini

:: for shutdown 4 master servers
start E:\xampp\mysql_master\bin\mysqladmin -P 3316 -u root shutdown
start E:\xampp\mysql_master\bin\mysqladmin -P 3317 -u root shutdown
start E:\xampp\mysql_master\bin\mysqladmin -P 3318 -u root shutdown
start E:\xampp\mysql_master\bin\mysqladmin -P 3319 -u root shutdown

:: for run mysql clients
start "Mysql Client localhost 3316" E:\xampp\mysql_master\bin\mysql -P 3316 -u root
start "Mysql Client localhost 3317" E:\xampp\mysql_master\bin\mysql -P 3317 -u root
start "Mysql Client localhost 3318" E:\xampp\mysql_master\bin\mysql -P 3318 -u root
start "Mysql Client localhost 3319" E:\xampp\mysql_master\bin\mysql -P 3319 -u root

