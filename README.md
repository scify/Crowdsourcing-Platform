# ECAS Crowdsourcing Web Application

Laravel 5.5 web application for the ECAS Crowdsourcing Platform project

##First time install (setup database and install dependencies)

0. Make sure php 7.1 (or newer) is installed.

Install graphics library 

```
 sudo apt-get install php7.1-gd
```

1. After cloning the project, create an .env file (should be a copy of .env.example),
containing the information about your database name and credentials.
Then run ```php artisan migrate``` to create the DB schema and
```php artisan db:seed --class=DatabaseSeederRunOnEmptyDB``` in order to insert the starter data to the DB

2. Install laravel/back-end dependencies
```
composer install

composer update
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

##Apache configuration:

The following assumes that the website will be rendered under dev.ecas url.
You can edit the /etc/hosts/ file and add a record  ```127.0.0.1       dev.ecas```


```
% sudo touch /etc/apache2/sites-available/ecas.conf
% sudo nano /etc/apache2/sites-available/ecas.conf
<VirtualHost *:80>
       
        ServerName dev.ecas
        ServerAlias dev.ecas
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
% cd /etc/apache2/sites-enabled && sudo ln -s ../sites-available/ecas.conf
```
Enable mod_rewrite and restart apache:
```
% sudo a2enmod rewrite && sudo service apache2 restart
```
Fix permissions for storage directory:
```
sudo chown -R user:www-data storage
chmod 775 storage
cd storage/
find . -type f -exec chmod 664 {} \;
find . -type d -exec chmod 775 {} \;
```

Change host file so ecas.dev points to to localhost 
```$xslt
sudo nano /etc/hosts
127.0.0.1       dev.ecas

```

##Social Login - Sign Up with Socialite
This app uses [Socialite Laravel Plugin](https://laravel.com/docs/5.6/socialite) to handle social login.

In order to get it working in your development environment, you need to make sure that you have API keys and secrets for 
Facebook and Twitter (guides [here](https://appdividend.com/2017/07/12/laravel-facebook-login/) and [here](https://appdividend.com/2017/07/21/laravel-5-twitter-login/)),
and that you can access [https://dev.ecas/](https://dev.ecas/) (notice the https) on your machine.

A guide for enabling https on your local machine can be found [here](https://deliciousbrains.com/https-locally-without-browser-privacy-errors/).

Basically, you need to run 
```bash
openssl req -new -sha256 -newkey rsa:2048 -nodes \
-keyout dev.ecas.key -x509 -days 365 \
-out dev.ecas.crt
```

And then reference the 2 files generated in the .conf file of the application (located in `/etc/apache2/sites-available` for Apache).

```bash
SSLEngine on
SSLCertificateFile "/path/to/dev.ecas.crt"
SSLCertificateKeyFile "/path/to/dev.ecas.key"
```

Also, make sure to restart Apache, by running

```bash
sudo service apache2 restart
```

##Start web server
Start web server
```
% php artisan serve
```
and navigate to localhost:8000.


## Deploying
You can run either  ```php artisan serve``` or set up a symbolic link to ```/path/to/project/public``` directory and navigate to http://localhost/{yourLinkName}


## Related HTML Template
This project uses the free [AdminLTE](https://adminlte.io/themes/AdminLTE/index2.html) template. 
More specifically, it makes use of [Laravel-AdminLTE](https://github.com/jeroennoten/Laravel-AdminLTE)
for easier integration.

