#!/bin/sh

# see http://linux.die.net/man/8/iptables
# see http://www.r00t.so/sysadmin/comment-rendre-mysql-accessible-depuis-lexterieur-102

# on flush
sudo iptables -F

# politique de fermerutre tous les ports (a ne pas faire)
# sudo iptables -P INPUT DROP
# sudo iptables -P FORWARD DROP
# sudo iptables -P OUTPUT DROP

# afficher le iptables
sudo iptables -L

# voir les processus en ecoute
sudo netstat --inet -npl -a
sudo netstat -nap

# ne pas casser les conexions etablies
sudo iptables -A INPUT -m state --state RELATED,ESTABLISHED -j ACCEPT
sudo iptables -A OUTPUT -m state --state RELATED,ESTABLISHED -j ACCEPT

# autorise le loopback
sudo iptables -A INPUT -i lo -j ACCEPT
sudo iptables -A OUTPUT -o lo -j ACCEPT
echo "loopback"

# ssh in/out
sudo iptables -A INPUT -p tcp --dport 22 -j ACCEPT
sudo iptables -A OUTPUT -p tcp --dport 22 -j ACCEPT
echo "ssh ok"

# http in/out
sudo iptables -A INPUT -p tcp --dport 80 -j ACCEPT
sudo iptables -A OUTPUT -p tcp --dport 80 -j ACCEPT
echo "http ok"

# https in/out
sudo iptables -A INPUT -p tcp --dport 443 -j ACCEPT
sudo iptables -A OUTPUT -p tcp --dport 443 -j ACCEPT
echo "https ok"

# mysql in/out
sudo iptables -A INPUT -p tcp --dport 3306 -j ACCEPT
sudo iptables -A OUTPUT -p tcp --dport 3306 -j ACCEPT
echo "mysql ok"

# bloque une adress ip
# iptables -A -s 100.100.100.100 -j DROP

# view iptables
sudo iptables -L
echo "view iptables"

# voir les processus en ecoute
sudo netstat --inet -npl -a
echo "view netstat"

# save all rules
# sudo -s iptables-save -c
# sudo -s sh -c "iptables-save > /etc/iptables.rules"

# run
# sudo service iptables-persistent

# end script
echo "end script"

# faire une copie du script dans /etc/init.d a fin que le script s'execute a chaque demmarage du machine
# sudo cp fireware.sh /etc/init.d/
# sudo chmod +x fireware.sh
# sudo update-rc.d fireware.sh defaults
