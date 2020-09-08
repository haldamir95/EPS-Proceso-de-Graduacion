FROM debian:stretch
RUN apt-get update

# PHP 7.2
RUN apt-get -y install apt-transport-https lsb-release ca-certificates wget curl gnupg
RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
RUN sh -c 'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list'
RUN apt-get update
RUN apt-get install -y php7.2-cli php7.2-xml php7.2-mbstring php7.2-zip php7.2-pgsql php7.2-intl

# Composer
COPY composer-installer.sh /home/
RUN chmod 764 /home/composer-installer.sh
RUN /home/composer-installer.sh
RUN mv composer.phar /usr/local/bin/composer

# Node.js 10
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get install -y nodejs

# Yarn "stable"
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update && apt-get install yarn
