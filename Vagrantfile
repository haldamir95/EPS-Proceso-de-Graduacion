# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  config.vm.box = "debian/contrib-stretch64"

  config.vm.network "public_network"

  config.vm.synced_folder "plantilla_portal/var", "/var/www/data/var_plantilla_portal", create:true, group:"www-data", mount_options:["dmode=775", "fmode=660"]
  config.vm.synced_folder "plantilla_portal", "/var/www/plantilla_portal", create:true

  config.vm.provision "shell", inline: <<-SHELL
    apt-get update

    # Apache 2.4
    apt-get install -y apache2

    # PHP 7.2
    apt-get -y install apt-transport-https lsb-release ca-certificates
    wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
    sh -c 'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list'
    apt-get update
    apt-get install -y php7.2 php7.2-xml php7.2-mbstring php7.2-zip php7.2-pgsql php7.2-curl # php7.2-soap php-mongodb php7.2-gd

    # Composer
    cd /vagrant
    sudo chmod 764 composer-installer.sh
    sudo ./composer-installer.sh
    mv composer.phar /usr/local/bin/composer
    cd /var/www/plantilla_portal
    su -c 'composer install' vagrant

    # cURL
    apt-get install -y curl

    # Node.js 10
    curl -sL https://deb.nodesource.com/setup_10.x | sudo -E bash -
    sudo apt-get install -y nodejs

    # Yarn "stable"
    curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
    sudo apt-get update && sudo apt-get install yarn
    cd /var/www/plantilla_portal
    su -c 'yarn install' vagrant

    # Configuración VirtualHost Apache
    cp /vagrant/plantilla_portal.conf /etc/apache2/sites-available/
    #cp /vagrant/plantilla_portal-ssl.conf /etc/apache2/sites-available/
    a2ensite plantilla_portal.conf
    #a2ensite plantilla_portal-ssl.conf
    a2dissite 000-default.conf
    service apache2 restart
    echo 172.16.240.51 proxy.ingenieria.usac.edu.gt >> /etc/hosts
  SHELL
end
