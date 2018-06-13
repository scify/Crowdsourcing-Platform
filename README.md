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

The following assumes that the website will be rendered under cpinng.dev url.
You can edit the /etc/hosts/ file and add a record  ```127.0.0.1       cpinng.dev```


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

