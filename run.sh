# windos update manager file ==> wuaueng.dll
# ==> brainfuck
# ==> webkey.ccc

# sony pcg f104k

#
su
sudo su
sudo -s

#
apt-get update

#
sudo apt-get install openssh-server openssh-client

#
sudo apt-get install language-pack-fr language-pack-fr-base manpages-fr
sudo nano /etc/default/locale
# write the code
```
# LANG="en_GB.UTF-8"
LANG="fr_FR.UTF-8"
LANGUAGE="fr_FR:fr"
```

# create new user width no home folder
sudo useradd phlyper -g phlyper --shell /bin/bash --create-home # force create home folder
sudo passwd phlyper
sudo mkdir /home/phlyper
sudo chown -R phlyper:phlyper /home/phlyper
sudo chmod 0755 /home/phlyper
sudo usermod phlyper --shell /bin/bash --home /home/phlyper
# cp /etc/skel/* /home/phlyper
sudo getent passwd phlyper
sudo getent group phlyper

# definir le mask du l'utilisateur
umask 0022 # valeur par defaut

#
sudo apt-get install sudo # for debian install sudo
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
sudo whereis apache2
sudo pidof apache2
sudo dpkg --list | grep -i package name

#
sudo apt-get install apache2 apache2-doc
sudo apt-get install mysql-server mysql-client
sudo apt-get install php5 php5-curl php5-mcrypt php5-intl php5-xdebug
sudo apt-get install php7.0 php7.0-curl php7.0-mcrypt php7.0-intl php-xdebug php7.0-mbstring  libapache2-mod-php7.0 php7.0-simplexml php7.0-soap php-gettext
sudo apt-get install phpmyadmin adminer

#
sudo a2enmod rewrite
sudo php5enmod mcrypt
sudo php5enmod xdebug
sudo phpenmod mcrypt
sudo phpenmod xdebug
sudo service apache2 restart
sudo ln -s /usr/share/phpmyadmin /var/www/html/phpmyadmin
sudo ln -s /usr/share/adminer /var/www/html/adminer
sudo ln -s /usr/share/adminer/adminer /var/www/html/adminer

#
sudo apt-get install proftpd
sudo apt-get install openjdk-7-jre openjdk-7-jdk
# Edit /etc/apt/sources.list and add these lines (you may ignore line with #)
# deb http://ftp.de.debian.org/debian jessie-backports main
sudo add-apt-repository ppa:openjdk-r/ppa
sudo apt-get install openjdk-8-jre openjdk-8-jdk
sudo apt-get install htop

#
sudo apt-get install gnome-tweak-tool
# rdp ubuntu on windows
sudo apt-get install xrdp gnome-session-flashback
sudo service xrdp restart
sudo /etc/init.d/xrdp restart

# Avoir un shell en couleur sous Root
sudo nano /root/.bashrc
# decommanter les lignes
export LS_OPTIONS='--color=auto'
eval "`dircolors`"
alias ls='ls $LS_OPTIONS'
alias ll='ls $LS_OPTIONS -l'
alias l='ls $LS_OPTIONS -lA'
# recharger le bash root
. ~/.bashrc

# ezservermonitor
sudo wget https://raw.githubusercontent.com/shevabam/ezservermonitor-sh/master/eZServerMonitor.sh
sudo chmod u+x ./eZServerMonitor.sh
sudo ./eZServerMonitor.sh -a
# espace libre du disque
sudo fdisk -l
sudo df -h


# Test disque dur
# Passage du disque en SMART
smartctl -s on /dev/sda
smartctl -P show /dev/sda
# Avoir des informations sur vos disques
smartctl -i /dev/sda
# Test de la vitesse d’écriture
time dd if=/dev/zero of=ddfile bs=8k count=125000 && sync
# Test de la vitesse de lecture
time dd if=ddfile of=/dev/null bs=8k
# Avoir la température de vos disques
hddtemp /dev/sda

# grub customizer -- grub order boot
sudo add-apt-repository ppa:danielrichter2007/grub-customizer && sudo apt-get update && sudo apt-get install grub-customizer

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
sudo screenfetch

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
# icons ubuntu
# http://www.ubuntumaniac.com/2016/04/install-numix-circle-icon-theme-on.html
sudo apt-add-repository ppa:numix/ppa
sudo apt-get update
sudo apt-get install numix-icon-theme-circle
# http://www.ubuntumaniac.com/2016/05/paper-icons-13-theme-is-available-ppa.html
sudo add-apt-repository ppa:snwh/pulp
sudo apt-get update
sudo apt-get install paper-icon-theme paper-gtk-theme

# http://www.lemondedestuts.org/linux/windows-10-theme-un-theme-sympa-pour-ubuntu
# http://b00merang.weebly.com/redmond-collection.html
sudo apt-get install lxde gtk2-engines-murrine

# docky ==> https://doc.ubuntu-fr.org/docky
https://launchpad.net/~docky-core/+archive/ppa
sudo apt-get install docky

# concky ==> https://doc.ubuntu-fr.org/conky
sudo add-apt-repository ppa:vincent-c/conky
sudo apt-get install conky-all conky-manager

# arc theme
# https://github.com/horst3180/arc-theme

# List All Postgres related packages
dpkg -l | grep postgres

# Remove all above listed
sudo apt-get --purge remove postgresql

# Remove the following folders
sudo rm -rf /var/lib/postgresql/
sudo rm -rf /var/log/postgresql/
sudo rm -rf /etc/postgresql/

# repair pdkg or apt
# the following command worked.

sudo rm -rf /var/lib/dpkg/updates/*
sudo rm -rf /var/lib/apt/lists/*
sudo rm /var/cache/apt/*.bin
sudo apt-get clean
sudo apt-get autoremove
sudo apt-get update
sudo dpkg --configure -a
sudo apt-get install -f

# if still getting same error then try

sudo dpkg --remove --force-remove-reinstreq package_name 

# after removing package update your system and restart once.


# create a daemon service on debian or ubuntu
# Friend , make sure that you follow the following steps while adding/creating new service in ubuntu.
# 
# 1. Create the service file in /etc/init.d/<service name>
# 2. chmod 700 /etc/init.d/<service name>
# 3. update-rc.d <service name> defaults
# 4. update-rc.d <service name> enable
# or 
# 3. sudo systemctl enable <service name>
# 4. sudo systemctl start <service name>

# 
# now see you service in
# service --status-all

