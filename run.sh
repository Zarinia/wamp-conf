# windos update manager file ==> wuaueng.dll

#
su

#
apt-get update

#
sudo apt-get install openssh-server openssh-client

#
sudo apt-get install sudo
sudo usermod -aG www-data phlyper # for apache (ubuntu & debian)
sudo usermod -aG sudo phlyper # for debian use sudo
sudo cat /etc/passwd | grep phlyper
sudo cat /etc/group | grep phlyper

#
sudo apt-get install apache2
sudo apt-get install php5 php5-curl php5-mcrypt php5-intl php5-xdebug
sudo apt-get install mysql-server mysql-client
sudo apt-get install phpmyadmin adminer

#
sudo apt-get install proftpd
sudo apt-get install openjdk-7-jdk
sudo apt-get install htop

#
sudo a2enmod rewrite
sudo service apache2 restart
sudo ln -s /usr/share/phpmyadmin /var/www/phpmyadmin
sudo ln -s /usr/share/adminer /var/www/adminer

# http://www.lfd.uci.edu/~gohlke/pythonlibs/#mysql-python
sudo apt-get install python-dev libmysqlclient-dev
sudo pip install MySQL-python
sudo apt-get install python-setuptools python3-setuptools python-pip python3-pip
sudo pip install virtualenv graphviz
sudo pip install --upgrade pip 
sudo pip install --upgrade virtualenv


# themes ubuntu
# http://www.noobslab.com/2015/11/stylishdark-theme-with-3-variants.html
sudo add-apt-repository ppa:noobslab/themes
sudo apt-get update
sudo apt-get install stylishdark-theme
# http://www.noobslab.com/2012/07/install-malys-inversio-themes-on.html
sudo add-apt-repository ppa:noobslab/malys-themes
sudo apt-get update
sudo apt-get install malys-inversio
