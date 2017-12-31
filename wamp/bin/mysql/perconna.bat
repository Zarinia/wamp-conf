mkdir /var/lib/mysql3307
chown -R mysql:mysql /var/lib/mysql3307

touch /var/log/mysql/error3307.log
chown -R mysql:adm /var/log/mysql/error3307.log

touch /var/run/mysqld/mysqld3307.pid
chown -R mysql:mysql /var/run/mysqld/mysqld3307.pid

touch /var/run/mysqld/mysqld3307.sock
chmod 777 /var/run/mysqld/mysqld3307.sock
chown -R mysql:mysql /var/run/mysqld/mysqld3307.sock

cp /etc/mysql/my.cnf /etc/mysql/my3307.cnf
cp -R /etc/mysql/percona-server.conf.d /etc/mysql/percona-server3307.conf.d

# initialize server datadir
/usr/sbin/mysqld --initialize --datadir=/var/lib/mysql3307 --defaults-file=/etc/mysql/my3307.cnf
sudo -b mysqld_safe --defaults-file=/etc/mysql/my3307.cnf --user=mysql

mysql_secure_installation --host=localhost --port=3307 --defaults-file=/etc/mysql/my3307.cnf --user=root --password=azerty

mysqld --initialize  --user=mysql --datadir=/var/lib/mysql3307

/usr/sbin/mysqld --basedir=/usr --defaults-file=/etc/mysql/my3307.cnf --datadir=/var/lib/mysql3307 --plugin-dir=/usr/lib/mysql/plugin --log-error=/var/log/mysql/error3307.log --pid-file=/var/run/mysqld/mysqld3307.pid --socket=/var/run/mysqld/mysqld3307.sock --port=3307

mysqld --port=3307 --defaults-file=/etc/mysql/my3307.cnf















