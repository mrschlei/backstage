#!/bin/sh

# Redirect logs to stdout and stderr for docker reasons.
ln -sf /dev/stdout /var/log/apache2/access_log
ln -sf /dev/stderr /var/log/apache2/error_log

# Apache and virtual host secrets
ln -sf /secrets/apache2/apache2.conf /etc/apache2/apache2.conf
ln -sf /secrets/apache2/ports.conf /etc/apache2/ports.conf
ln -sf /secrets/apache2/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf
ln -sf /secrets/apache2/cosign.conf /etc/apache2/mods-available/cosign.conf

# app secrets
ln -sf /secrets/app/settings.php /var/www/html/sites/default/settings.php

# app and php secrets, oci8 and Oracle instantclient
ln -sf /secrets/php/php.ini /usr/local/etc/php/php.ini

mkdir -p /usr/lib/oracle/12.2/client64
ln -sf /secrets/app/oracle.sh /etc/profile.d/oracle.sh
# instead of this..
#/bin/sh /etc/profile.d/oracle.sh
# do this:
export ORACLE_HOME=/usr/lib/oracle/12.2/client64
export PATH=$ORACLE_HOME/bin:$PATH
export TNS_ADMIN=/etc/oracle

ln -sf /secrets/app/settings.php /var/www/html/sites/default/settings.php
#ln -sf /secrets/app/tnsnames.ora /usr/local/etc/php/conf.d/tnsnames.ora
mkdir /etc/oracle
ln -sf /secrets/app/tnsnames.ora /etc/oracle/tnsnames.ora

mkdir -p /opt/oracle/instantclient_12_2/network/admin
cd /opt/oracle			
# instantclient packages are too large to be secret
#ln /var/www/html/instantclient-basic-linux.x64-12.2.0.1.0.zip /opt/oracle
mv /var/www/html/instantclient-basic-linux.x64-12.2.0.1.0.zip /opt/oracle
unzip instantclient-basic-linux.x64-12.2.0.1.0.zip
cd /opt/oracle/instantclient_12_2
ln -s libclntsh.so.12.1 libclntsh.so
ln -s libocci.so.12.1 libocci.so
ln -s /opt/oracle/instantclient_12_2 /opt/oracle/instantclient
#apt-get install libaio # do this in Dockerfile
export LD_LIBRARY_PATH=/opt/oracle/instantclient:$LD_LIBRARY_PATH
export PATH=/opt/oracle/instantclient:$PATH

cd /opt/oracle
mv /var/www/html/instantclient-sdk-linux.x64-12.2.0.1.0.zip /opt/oracle
unzip instantclient-sdk-linux.x64-12.2.0.1.0.zip

pecl channel-update pecl.php.net
echo "instantclient,/opt/oracle/instantclient_12_2" | pecl install oci8 
ln -sf /secrets/app/docker-php-ext-oci8.ini /usr/local/etc/php/conf.d/docker-php-ext-oci8.ini

# SSL secrets
ln -sf /secrets/ssl/USERTrustRSACertificationAuthority.pem /etc/ssl/certs/USERTrustRSACertificationAuthority.pem
ln -sf /secrets/ssl/AddTrustExternalCARoot.pem /etc/ssl/certs/AddTrustExternalCARoot.pem
ln -sf /secrets/ssl/sha384-Intermediate-cert.pem /etc/ssl/certs/sha384-Intermediate-cert.pem
ln -sf /secrets/ssl/its-backstage.openshift.dsc.umich.edu.cert /etc/ssl/certs/its-backstage.openshift.dsc.umich.edu.cert
ln -sf /secrets/ssl/its-backstage.openshift.dsc.umich.edu.key /etc/ssl/private/its-backstage.openshift.dsc.umich.edu.key

## Rehash command needs to be run before starting apache.
c_rehash /etc/ssl/certs

a2enmod authnz_ldap
a2enmod ssl
a2enmod include
a2ensite default-ssl 

## set SGID for www-data 
chown -R www-data.www-data /var/www/html /var/cosign
chmod -R 2775 /var/www/html /var/cosign

/usr/local/bin/apache2-foreground
