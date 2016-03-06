mysql_upgrade

mysqlcheck --all-databases --check-upgrade --auto-repair
mysql < fix_priv_tables
mysqlcheck --all-databases --check-upgrade --fix-db-names --fix-table-names

mysqlcheck –all-databases –check-upgrade –auto-repair
mysql < fix_priv_tables
mysqlcheck –all-databases –check-upgrade –auto-repair –fix-db-names –fix-table-names

mysql_upgrade -h <host> -u <mysqluser> -p<pass>
