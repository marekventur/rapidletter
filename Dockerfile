FROM ubuntu:trusty
MAINTAINER Marek Ventur <marekventur@gmail.com>

# Install base packages
ENV DEBIAN_FRONTEND noninteractive
RUN apt-get update && \
    apt-get -yq install apache2 libapache2-mod-php5 php5-gd php5-curl php-pear php-apc php5-pgsql && \
    rm -rf /var/lib/apt/lists/*
RUN sed -i "s/variables_order.*/variables_order = \"EGPCS\"/g" /etc/php5/apache2/php.ini

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