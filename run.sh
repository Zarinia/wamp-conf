# windos update manager file ==> wuaueng.dll
# ==> brainfuck
# ==> webkey.ccc
#
su
sudo su
sudo -s

#
apt-get update

#
sudo apt-get install openssh-server openssh-client

#
sudo apt-get install sudo
sudo usermod -aG www-data phlyper # for apache (ubuntu & debian)
sudo usermod -aG sudo phlyper # for debian use sudo
sudo usermod -aG root phlyper # for root user (optional)
sudo cat /etc/passwd | grep phlyper
sudo cat /etc/group | grep phlyper

#
sudo ln -s /var/www /home/phlyper/www

#
sudo chmod -R 775 /var/www/html
sudo chmod -R 777 /var/www/html
sudo chown -R www-data:www-data /var/www/html
sudo chown -R phlyper:phlyper /var/www/html

#
sudo apt-get install apache2
sudo apt-get install php5 php5-curl php5-mcrypt php5-intl php5-xdebug
sudo apt-get install mysql-server mysql-client
sudo apt-get install phpmyadmin adminer

#
sudo apt-get install proftpd
sudo apt-get install openjdk-7-jdk
sudo apt-get install htop

# grub customizer -- grub order boot
sudo add-apt-repository ppa:danielrichter2007/grub-customizer && sudo apt-get update && sudo apt-get install grub-customizer

#
sudo a2enmod rewrite
sudo php5enmod mcrypt
sudo php5enmod xdebug
sudo service apache2 restart
sudo ln -s /usr/share/phpmyadmin /var/www/phpmyadmin
sudo ln -s /usr/share/adminer /var/www/adminer

# webalizer https://doc.ubuntu-fr.org/webalizer
mkdir ~/webalizer
wget ftp://ftp.mrunix.net/pub/webalizer/webalizer-2.21-02-src.tgz
tar -zxvf webalizer-2.21-02-src.tgz
cd webalizer-2.21-02
sudo apt-get install zlib1g-dev libpng12-dev libgd2-noxpm-dev
./configure --with-language=french
make
sudo make install
cd /usr/local/etc/
sudo cp webalizer.conf.sample webalizer.conf
sudo nano webalizer.conf
sudo webalizer

# Hardinfo : afficher les informations système sous Linux
sudo apt-get install hardinfo

# screenFetch - The Bash Screenshot Information Tool
# https://github.com/KittyKatt/screenFetch
# sudo add-apt-repository ppa:djcj/screenfetch
sudo deb http://ppa.launchpad.net/djcj/screenfetch/ubuntu YOUR_UBUNTU_VERSION_HERE main 
sudo deb-src http://ppa.launchpad.net/djcj/screenfetch/ubuntu YOUR_UBUNTU_VERSION_HERE main 
sudo apt-get install screenfetch

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
# http://www.noobslab.com/2016/01/yosembiance-smooth-and-sleek-theme.html
sudo add-apt-repository ppa:noobslab/themes
sudo apt-get update
sudo apt-get install yosembiance-gtk-theme

# docky ==> https://doc.ubuntu-fr.org/docky
https://launchpad.net/~docky-core/+archive/ppa
sudo apt-get install docky

# concky ==> https://doc.ubuntu-fr.org/conky
sudo add-apt-repository ppa:vincent-c/conky
sudo apt-get install conky-all conky-manager
