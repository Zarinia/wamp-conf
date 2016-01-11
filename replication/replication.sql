show variables like "%host%";
show variables like "%port%";
show variables like "%server%";

-- for master
CREATE DATABASE base;

SHOW DATABASES;

GRANT REPLICATION SLAVE, SELECT, SUPER, RELOAD ON *.* TO 'replication_user'@'localhost' IDENTIFIED BY 'slave';
FLUSH PRIVILEGES;

/etc/init.d/mysql restart

FLUSH TABLES WITH READ LOCK;
SHOW MASTER STATUS;

UNLOCK TABLES;

mysqldump -u root -p --create-options --master-data -B base > ..\base.sql

-- for slave

mysql -u  root -p  < /root/base.sql

-- localhost 3317 (mater) ===> localhost 3316 (slave)
-- set config in **slave server**
STOP SLAVE;
CHANGE MASTER TO MASTER_HOST='localhost', MASTER_PORT=3316, MASTER_USER='replication_user', MASTER_PASSWORD='slave', MASTER_LOG_FILE='mysql-bin.000006', MASTER_LOG_POS=107;
START SLAVE;

GRANT REPLICATION SLAVE, SELECT, SUPER, RELOAD ON *.* TO 'replication_user'@'localhost' IDENTIFIED BY 'slave';
FLUSH PRIVILEGES;

-- for master

-- localhost 3316 (slave) ===> localhost 3317 (mater)
-- set config in **slave mater**
STOP SLAVE;
CHANGE MASTER TO MASTER_HOST='localhost', MASTER_PORT=3317 , MASTER_USER='replication_user', MASTER_PASSWORD='slave', MASTER_LOG_FILE='mysql-bin.000006', MASTER_LOG_POS=107;
START SLAVE;

-- test

-- for master
USE base;
 
CREATE TABLE matable(id INT Not Null, texte varchar(256) Not Null) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

SHOW TABLES;

INSERT INTO matable VALUES ('1', 'Le texte 1');
INSERT INTO matable VALUES ('2', 'Le texte 2');

SELECT * FROM matable;

-- for slave
USE base;

SHOW TABLES;

SELECT * FROM matable;

INSERT INTO matable VALUES ('3', 'Le texte 3');
INSERT INTO matable VALUES ('4', 'Le texte 4');

SELECT * FROM matable;

-- for master
SELECT * FROM matable;

-- dbip
desc `dbip-country-2015-12`;
desc `dbip-country-2016-01`;
select count(*) from `dbip-country-2015-12` union select count(*) from `dbip-country-2016-01`;

SHOW MASTER STATUS \G;
SHOW SLAVE STATUS \G;
SHOW PROCESSLIST \G;


-------------------------------------------------------
-- in console localhost 3317
STOP SLAVE;
CHANGE MASTER TO MASTER_HOST='localhost', MASTER_PORT=3316, MASTER_USER='replication_user', MASTER_PASSWORD='slave', MASTER_LOG_FILE='mysql-bin.000013', MASTER_LOG_POS=107;
START SLAVE;

-- in console localhost 3318
STOP SLAVE;
CHANGE MASTER TO MASTER_HOST='localhost', MASTER_PORT=3317, MASTER_USER='replication_user', MASTER_PASSWORD='slave', MASTER_LOG_FILE='mysql-bin.000013', MASTER_LOG_POS=107;
START SLAVE;

-- in console localhost 3319
STOP SLAVE;
CHANGE MASTER TO MASTER_HOST='localhost', MASTER_PORT=3318, MASTER_USER='replication_user', MASTER_PASSWORD='slave', MASTER_LOG_FILE='mysql-bin.000013', MASTER_LOG_POS=107;
START SLAVE;

-- in console localhost 3316
STOP SLAVE;
CHANGE MASTER TO MASTER_HOST='localhost', MASTER_PORT=3319, MASTER_USER='replication_user', MASTER_PASSWORD='slave', MASTER_LOG_FILE='mysql-bin.000013', MASTER_LOG_POS=107;
START SLAVE;

