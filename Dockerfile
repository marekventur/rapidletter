FROM ubuntu:trusty
MAINTAINER Marek Ventur <marekventur@gmail.com>

# Install base packages
ENV DEBIAN_FRONTEND noninteractive
RUN apt-get update && \
    apt-get -yq install apache2 libapache2-mod-php5 php5-pgsql php5-imagick && \
    rm -rf /var/lib/apt/lists/*

RUN sed -i "s/variables_order.*/variables_order = \"EGPCS\"/g" /etc/php5/apache2/php.ini
RUN sed -i "s/AllowOverride.*/AllowOverride All/g" /etc/apache2/apache2.conf
RUN a2enmod rewrite

# Add image configuration and scripts
ADD run.sh /run.sh
RUN chmod 755 /*.sh

RUN mkdir -p /app && rm -fr /var/www/html && ln -s /app /var/www/html
ADD conf/ports.conf /etc/apache2/ports.conf
ADD conf/000-default.conf /etc/apache2/sites-enabled/000-default.conf
ADD run.sh /run.sh
RUN chown www-data:www-data /app -R

EXPOSE 36004
WORKDIR /app
CMD ["/run.sh"]

## docker build --tag=marekventur/rapidletter . ; docker run --rm -it --net=host --env "ROOT_URL=http://localhost:36004" -v `pwd`:/app marekventur/rapidletter  /bin/bash