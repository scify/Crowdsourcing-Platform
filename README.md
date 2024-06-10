# Crowdsourcing Web Application

[![GitHub Issues](https://img.shields.io/github/issues/scify/Crowdsourcing-Platform)](https://img.shields.io/github/issues/scify/Crowdsourcing-Platform)
[![GitHub Stars](https://img.shields.io/github/stars/scify/Crowdsourcing-Platform)](https://img.shields.io/github/stars/scify/Crowdsourcing-Platform)
[![GitHub forks](https://img.shields.io/github/forks/scify/Crowdsourcing-Platform)](https://img.shields.io/github/forks/scify/Crowdsourcing-Platform)
[![JavaScript Style Guide: Good Parts](https://img.shields.io/badge/code%20style-goodparts-brightgreen.svg?style=flat)](https://github.com/dwyl/goodparts "JavaScript The Good Parts")
[![contributions welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat)](https://github.com/dwyl/esta/issues)
[![License](https://img.shields.io/badge/License-Apache%202.0-blue.svg)](https://opensource.org/licenses/Apache-2.0)
[![Maintenance](https://img.shields.io/badge/Maintained%3F-yes-green.svg)](https://GitHub.com/Naereen/StrapDown.js/graphs/commit-activity)
[![Website shields.io](https://img.shields.io/website-up-down-green-red/http/shields.io.svg)](https://crowdsourcing.scify.org/)
[![Ask Me Anything !](https://img.shields.io/badge/Ask%20me-anything-1abc9c.svg)](https://GitHub.com/scify)
[![GitHub release](https://img.shields.io/github/release/scify/Crowdsourcing-Platform.svg)](https://github.com/scify/Crowdsourcing-Platform/releases/tag/v7.7)

[Laravel](https://laravel.com/) 9 Web Application for Crowdsourcing Projects and Questionnaires

# Features

- Administration panel to set up of questionnaires & projects
- Questionnaires with and without login: Questionnaires can be responded anonymously or eponymoysly
- The questionnaires can be automatically translated via google translations (to facilitate the manual translations)
- The citizen responses are automatically translated via google translations  (and at the results you can see both the
  original and the translated)
- Setting targets for goals (number of responses needed for the questionnaire) to be reached
- Gamifications elements: The platform motivates users to respond to questionnaires or invite others to respond
- Mailchimp integration: All the email of registered users are collected to a mailchimp list
- Google Analytics integration (with anonymized settings turned on) with custom events: We track anonymously people who
  do actions in the website
- Voting mechanism for provided answers: Users can vote the best answers, Platform moderators can highlight the most
  interesting answers and reject/demote the not interesting ones
- Extract the results2021_12_20_115932_add_social_image_to_projects_table: You can download the answers to excel
- View statistics
- Login function with fb, g+, linkedin, twitter, windows
- Platform is available in many languages (and new translations can be added with relative low cost)
- GDPR compliant

## Benefits of Open Source applications

Offering the code under open source licenses includes many benefits. Of those, the ones related to our project, are:

- There is no dependency on the developer of the solution (SciFY), but other collaborators can be used after the end of
  the project. The code remains always freely available.
- Stakeholders can add features, change it, improve it, adjust to their needs.
- New contributions are added to the existing solution so that everyone benefit

# Organizations using the Crowdsourcing platform

[ECAS official installation](https://crowdsourcing.ecas.org/en)

[SciFY's official installation](https://crowdsourcing.scify.org/)

# Installation Instructions:

## First time install (setup database and install dependencies)

0. Make sure php 8.0 (or newer) is installed.

Install graphics library

```
 sudo apt-get install php-gd
```

1. After cloning the project, create an .env file (should be a copy of .env.example),
   containing the information about your database name and credentials.
   Then run ```php artisan migrate``` to create the DB schema and
   ```php artisan db:seed --class=DatabaseSeederRunOnEmptyDB``` in order to insert the starter data to the DB

2. Generate app key

```bash
php artisan key:generate
```

3. Install laravel/back-end dependencies

```bash
composer install

composer dump-autoload
```

4. Front-end dependencies

It is very easy to install multiple versions of NodeJS and npm, by
using [Node Version Manager (nvm)](https://github.com/creationix/nvm).

If you are using [`nvm`](https://github.com/nvm-sh/nvm), run this command in order to sync to the correct NodeJS version
for the project:

```bash
nvm use
```

Then, install and compile the front-end dependencies:

```bash
npm install

npm run dev # (if in development mode)

npm run prod # (if in production mode)

npm run watch # (if in development mode and you want to have live changes)
```

5. Set up the Database **(only if in new installation)**

Run the Laravel migrations:

```bash
php artisan migrate
```

Run the Database seeder:

```bash
php artisan db:seed
```

6. Create symbolic link for uploaded images
   By default images are stored at app/storage/public. Run

```bash
php artisan storage:link
```

in order to link this folder with the public directory

## Database Considerations

If you are running MySQL version 8.0 and above, there is a certain [bug](https://bugs.mysql.com/bug.php?id=103465)
regarding memory overflow when trying to sort results in tables that have columns of JSON data type.

A workaround to fix this is to tweak the memory buffer size for sorting.
In order to do so, please follow:

```bash
sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf
```

And append the following options:

```bash
[mysqld]
sort_buffer_size = 10485760
innodb_sort_buffer_size = 10485760
```

After you save the file, restart the MySQL service:

```bash
sudo service mysql restart
```

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

```bash
cd /etc/apache2/sites-enabled && sudo ln -s ../sites-available/crowdsourcing.conf
```

Enable mod_rewrite, mod_ssl and restart apache:

```bash
sudo a2enmod rewrite && sudo a2enmod ssl && sudo service apache2 restart
```

Fix permissions for storage directory:

```bash
sudo chown -R user:www-data storage

chmod 775 storage

cd storage/

find . -type f -exec chmod 664 {} \;

find . -type d -exec chmod 775 {} \;
```

The above steps can also be done in a better way, by using the companion script:

```bash
chmod +x set-file-permissions.sh

sudo ./set-file-permissions.sh www-data USER .
```

Change hosts file so `dev.crowdsourcing` points to localhost

```$xslt
sudo nano /etc/hosts

127.0.0.1       dev.crowdsourcing
```

## Social Login - Sign Up with Socialite

This app uses [Socialite Laravel Plugin](https://laravel.com/docs/5.6/socialite) to handle social login.

In order to get it working in your development environment, you need to make sure that you have API keys and secrets for
Facebook and Twitter (guides [here](https://appdividend.com/2017/07/12/laravel-facebook-login/)
and [here](https://appdividend.com/2017/07/21/laravel-5-twitter-login/)),
and that you can access [https://dev.crowdsourcing/](https://dev.crowdsourcing/) (notice the https) on your machine.

A guide for enabling https on your local machine can be
found [here](https://deliciousbrains.com/https-locally-without-browser-privacy-errors/).

Basically, you need to run

```bash
openssl req -new -sha256 -newkey rsa:2048 -nodes \
-keyout dev.crowdsourcing.key -x509 -days 365 \
-out dev.crowdsourcing.crt
```

And then reference the 2 files generated in the crowdsourcing.conf file of the application.
Make sure you change the port to 443 as shown below:

```
sudo touch /etc/apache2/sites-available/crowdsourcing.conf

sudo nano /etc/apache2/sites-available/crowdsourcing.conf

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

## SEO - Generate Sitemap

This application uses [Spatie - Laravel Sitemap](https://github.com/spatie/laravel-sitemap) plugin, in order to create
the `public/sitemap.xml` file (which is excluded from git), that will be crawled by the search engines.
In order to run the generator for the current application installation, run the embedded Laravel command:

```bash
php artisan sitemap:generate
```

## Related HTML Template

This project uses the free [AdminLTE](https://adminlte.io/docs/3.0/) template.

It also makes use of [Bootstrap 4](https://getbootstrap.com/docs/4.4/getting-started/introduction/)

## PHP code style - Laravel Pint

This application uses [Laravel Pint](https://laravel.com/docs/9.x/pint) in order to perform code-style.

In order to run the styler, run :

```bash

./vendor/bin/pint --test -v # the --test will not do any changes, it will just output the changes needed

./vendor/bin/pint -v # this command will actually perform the code style changes 

```

## Installation-specific resources

The application can be tweaked and personalized for each installation.
In the `.env` file you can set the `INSTALLATION_RESOURCES_DIR` variable accordingly. This variable must take a value
that represents a directory name in the `resourcess/views/home/partials` directory. For example, see
the `resourcess/views/home/partials/together` directory. This directory must contain the partial blade files for the
installation.

## Run Tests

You may use a separate MySQL database, for testing purposes.
Generally, the fields for testing should be defined in a `.env.testing` file, which should start as a copy of
the `.env.testing.example` file.
Then, run the `migrate` and `seed` commands for the testing Database:

```bash
cp .env.testing.example .env.testing

php artisan migrate --env=testing

php artisan db:seed --env=testing --class=DatabaseSeeder
```

## How to debug

- Install and configure Xdebug on your machine
- At Chrome
  install [Xdebug helper](https://chrome.google.com/webstore/detail/xdebug-helper/eadndfjplgieldjbigjakmdgkmoaaaoc?utm_source=chrome-app-launcher-info-dialog)
- At PhpStorm/IntelliJ click the "Start listening for PHP debug connections"

## Contributing

To contribute to MyEIC Common Library, follow these steps:

1. Fork this repository.
2. Read the [CONTRIBUTING](CONTRIBUTING.md) file.
3. Create a branch: `git checkout -b <branch_name>`.
4. Make your changes and commit them: `git commit -m '<commit_message>'`
5. Push to the original branch: `git push origin <project_name>/<location>`
6. Create the pull request.

## License

This project is open-sourced software licensed under
the [Apache License, Version 2.0](https://www.apache.org/licenses/LICENSE-2.0).

## Credits

This project is developed by [SciFY](https://www.scify.org/) and [ECAS](https://ecas.org/) and is based on
the [Laravel](https://laravel.com/) framework. The project is maintained by [SciFY](https://www.scify.org/).