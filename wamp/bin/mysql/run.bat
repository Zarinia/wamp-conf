start mysqld --basedir "c:/wamp/bin/mysql/mysql5.7.18/data-3tformation"

mysqld -P 3326
mysqld --defaults-file="my.ini"

mysql -P 3326 -h localhost -u phlyper -pazerty

mysqldump -P 3326 -h localhost -u phlyper -p --databases 3tformation --result-file=dump_3tformation.sql
mysqldump -P 3326 -h localhost -u phlyper -p --databases playmestore --result-file=dump_playmestore.sql




