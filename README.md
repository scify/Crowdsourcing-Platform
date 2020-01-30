# Crowdsourcing Web Application

[![dependencies Status](https://david-dm.org/scify/Crowdsourcing-Platform/status.svg)](https://david-dm.org/scify/Crowdsourcing-Platform)
[![JavaScript Style Guide: Good Parts](https://img.shields.io/badge/code%20style-goodparts-brightgreen.svg?style=flat)](https://github.com/dwyl/goodparts "JavaScript The Good Parts")
[![HitCount](http://hits.dwyl.io/scify/Crowdsourcing-Platform.svg)](http://hits.dwyl.io/scify/Crowdsourcing-Platform)
[![contributions welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat)](https://github.com/dwyl/esta/issues)
[![License](https://img.shields.io/badge/License-Apache%202.0-blue.svg)](https://opensource.org/licenses/Apache-2.0)
[![Maintenance](https://img.shields.io/badge/Maintained%3F-yes-green.svg)](https://GitHub.com/Naereen/StrapDown.js/graphs/commit-activity)
[![Website shields.io](https://img.shields.io/website-up-down-green-red/http/shields.io.svg)](https://crowdsourcing.scify.org/)
[![Ask Me Anything !](https://img.shields.io/badge/Ask%20me-anything-1abc9c.svg)](https://GitHub.com/scify)

Laravel 6 Web Application for Crowdsourcing Projects and Questionnaires

[Project URL](https://crowdsourcing.scify.org/)

# Installation Instructions:

## First time install (setup database and install dependencies)

0. Make sure php 7.2 (or newer) is installed.

Install graphics library 

```
 sudo apt-get install php7.2-gd
```

1. After cloning the project, create an .env file (should be a copy of .env.example),
containing the information about your database name and credentials.
Then run ```php artisan migrate``` to create the DB schema and
```php artisan db:seed --class=DatabaseSeederRunOnEmptyDB``` in order to insert the starter data to the DB

2. Install laravel/back-end dependencies
```
composer install

```

3. Install front-end dependencies
```
npm install
```

4. Create symbolic link for uploaded images
By default images are stored at app/storage/public. Run
```
php artisan storage:link
```
to link this folder with the public directory

## Apache configuration:


```
% sudo touch /etc/apache2/sites-available/crowdsourcing.conf
% sudo nano /etc/apache2/sites-available/crowdsourcing.conf
<VirtualHost *:80>
       
        ServerName dev.crowdsourcing
        ServerAlias dev.crowdsourcing
        DocumentRoot "/home/path/to/project/public"
        <Directory "/home/path/to/project/public">
            Require all granted
            AllowOverride all
        </Directory>
       
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

</VirtualHost>
```
Make the symbolic link:
```
% cd /etc/apache2/sites-enabled && sudo ln -s ../sites-available/crowdsourcing.conf
```
Enable mod_rewrite, mod_ssl and restart apache:
```
% sudo a2enmod rewrite && sudo a2enmod ssl && sudo service apache2 restart
```
Fix permissions for storage directory:
```
sudo chown -R user:www-data storage
chmod 775 storage
cd storage/
find . -type f -exec chmod 664 {} \;
find . -type d -exec chmod 775 {} \;
```

Change hosts file so dev.crowdsourcing points to to localhost 
```$xslt
sudo nano /etc/hosts
127.0.0.1       dev.crowdsourcing

```

## Social Login - Sign Up with Socialite
This app uses [Socialite Laravel Plugin](https://laravel.com/docs/5.6/socialite) to handle social login.

In order to get it working in your development environment, you need to make sure that you have API keys and secrets for 
Facebook and Twitter (guides [here](https://appdividend.com/2017/07/12/laravel-facebook-login/) and [here](https://appdividend.com/2017/07/21/laravel-5-twitter-login/)),
and that you can access [https://dev.crowdsourcing/](https://dev.crowdsourcing/) (notice the https) on your machine.

A guide for enabling https on your local machine can be found [here](https://deliciousbrains.com/https-locally-without-browser-privacy-errors/).

Basically, you need to run 
```bash
openssl req -new -sha256 -newkey rsa:2048 -nodes \
-keyout dev.crowdsourcing.key -x509 -days 365 \
-out dev.crowdsourcing.crt
```

And then reference the 2 files generated in the crowdsourcing.conf file of the application.
Make sure you change the port to 443 as shown below:


```
% sudo touch /etc/apache2/sites-available/crowdsourcing.conf
% sudo nano /etc/apache2/sites-available/crowdsourcing.conf
<VirtualHost *:443>
	SSLEngine on
	SSLCertificateFile "/etc/apache2/sites-available/dev.crowdsourcing.crt"
	SSLCertificateKeyFile "/etc/apache2/sites-available/dev.crowdsourcing.key"

        ServerName dev.crowdsourcing
        ServerAlias dev.crowdsourcing
        DocumentRoot "/home/path/to/project/public"
        <Directory "/home/path/to/project/public">
            Require all granted
            AllowOverride all
        </Directory>
       
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```



Also, make sure to restart Apache, by running

```bash
sudo service apache2 restart
```

## Related HTML Template
This project uses the free [AdminLTE](https://adminlte.io/themes/AdminLTE/index2.html) template.

## Run Tests
We use a Sqlite database to generate an instance of the database, for testing purposes.
In order to create the database file, run the following commands:

```bash
touch storage/database_testing.sqlite

php artisan migrate --database=sqlite_testing

php artisan db:seed --database=sqlite_testing --class=DatabaseSeederRunOnEmptyDB
```

## How to debug
- Install and configure Xdebug on your machine
- At Chrome install [Xdebug helper](https://chrome.google.com/webstore/detail/xdebug-helper/eadndfjplgieldjbigjakmdgkmoaaaoc?utm_source=chrome-app-launcher-info-dialog)
- At PhpStorm/IntelliJ click the "Start listening for PHP debug connections"
