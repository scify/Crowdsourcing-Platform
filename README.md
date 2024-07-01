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

## Introduction

This is a [Laravel](https://laravel.com/) 9 Web Application for Crowdsourcing Projects and Questionnaires.

## Table of Contents

- [Introduction](#introduction)
- [Features](#features)
- [Organizations using the Crowdsourcing platform](#organizations-using-the-crowdsourcing-platform)
- [Installation Instructions](#installation-instructions)
    - [Method 1: Docker Compose](#method-1-docker-compose)
        - [Step 1: Install Docker and Docker Compose](#step-1-install-docker-and-docker-compose)
        - [Step 2: Build and Run Containers](#step-2-build-and-run-containers)
        - [Step 3: Launch the Application](#step-3-launch-the-application)
    - [Method 2: Manual Installation](#method-2-manual-installation)
        - [Step 1: Install PHP](#step-1-install-php)
        - [Step 2: Install Composer](#step-2-install-composer)
        - [Step 3: Install Node.js and npm](#step-3-install-nodejs-and-npm)
        - [Step 4: Install Nginx](#step-4-install-nginx)
            - [Nginx Configuration](#nginx-configuration)
        - [Step 5: Install MySQL](#step-5-install-mysql)
            - [Database Considerations](#database-considerations)
    - [Method 3: Ddev](#method-3-ddev)
        - [Step 1: Install Ddev](#step-1-install-ddev)
        - [Step 2: Start Ddev](#step-2-start-ddev)
- [Run the Laravel Application commands](#run-the-laravel-application-commands)
    - [Step 1: Create the `.env` file](#step-1-create-the-env-file)
    - [Step 2: Generate the application key](#step-2-generate-the-application-key)
    - [Step 3: Install Laravel (back-end) dependencies](#step-3-install-laravel-back-end-dependencies)
    - [Step 4: Install and compile the front-end dependencies:](#step-4-install-and-compile-the-front-end-dependencies)
    - [Step 5: Set up the Database **(only if in new installation)
      **](#step-5-set-up-the-database-only-if-in-new-installation)
    - [Step 6: Create symbolic link for uploaded files](#step-6-create-symbolic-link-for-uploaded-files)
    - [Step 7: Fix permissions for storage directory](#step-7-fix-permissions-for-storage-directory)
- [Social Login - Sign Up with Socialite](#social-login---sign-up-with-socialite)
- [SEO - Generate Sitemap](#seo---generate-sitemap)
- [Related HTML Template](#related-html-template)
- [PHP code style - Laravel Pint](#php-code-style---laravel-pint)
- [Installation-specific resources](#installation-specific-resources)
- [Run Tests](#run-tests)
- [How to debug](#how-to-debug)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)
- [Credits](#credits)
- [Contact](#contact)

## Features

- Administration panel to set up questionnaires & projects
- Questionnaires with and without login: Questionnaires can be responded anonymously or eponymoysly
- The questionnaires can be automatically translated via google translations (to facilitate the manual translations)
- The citizen responses are automatically translated via google translations  (and at the results you can see both the
  original and the translated)
- Setting targets for goals (number of responses needed for the questionnaire) to be reached
- Gamification elements: The platform motivates users to respond to questionnaires or invite others to respond
- Mailchimp integration: All the emails of registered users are collected to a mailchimp list
- Google Analytics integration (with anonymized settings turned on) with custom events: We track anonymously people who
  do actions in the website
- Voting mechanism for provided answers: Users can vote the best answers, Platform moderators can highlight the most
  interesting answers and reject/demote the not interesting ones
- Extract the results: You can download the answers to excel
- View statistics
- Login function with Facebook, Google, LinkedIn, Twitter, Microsoft
- The platform is available in many languages (and new translations can be added with relative low cost)
- GDPR compliant

## Benefits of Open Source applications

Offering the code under open source licenses includes many benefits. Of those, the ones related to our project, are:

- There is no dependency on the developer of the solution (SciFY), but other collaborators can be used after the end of
  the project. The code remains always freely available.
- Stakeholders can add features, change it, improve it, adjust to their needs.
- New contributions are added to the existing solution so that everyone benefit

# Organizations using the Crowdsourcing platform

[ECAS official installation](https://crowdsourcing.ecas.org/en)

[SciFY official installation](https://crowdsourcing.scify.org/)

# Installation Instructions

## Method 1: Docker Compose (recommended)

### Step 1: Install Docker and Docker Compose

- **Docker**: Follow the installation guide for your operating system on
  the [Docker website](https://docs.docker.com/get-docker/).
- **Docker Compose**: Docker Compose is included with Docker Desktop for Windows and Mac. For Linux, follow the
  instructions [here](https://docs.docker.com/compose/install/).

### Step 2: Build and Run Containers

Run the following command to build and start the containers:

```sh
docker-compose up --build
```

### Step 3: Launch the Application

The application will be available at [http://localhost:8080](http://localhost:8080).
To access PHPMyAdmin, visit [http://localhost:8081](http://localhost:8081).

## Method 2: Manual Installation

### Step 1: Install PHP

- **PHP**: Install PHP 8.0 or newer. You can follow the installation guide for your operating system on
  the [PHP website](https://www.php.net/manual/en/install.php).

```bash
sudo apt update

sudo apt install php php-cli php-fpm php-mysql php-xml php-mbstring php-curl php-gd php-zip php-bcmath
```

### Step 2: Install Composer

- **Composer**: Install Composer by following the instructions on
  the [Composer website](https://getcomposer.org/download/).

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

php composer-setup.php

php -r "unlink('composer-setup.php');"

sudo mv composer.phar /usr/local/bin/composer
```

### Step 3: Install Node.js and npm

- **Node.js**: Install Node.js and npm by following the instructions on
  the [Node.js website](https://nodejs.org/en/download/).

```bash
sudo apt install nodejs npm
```

Or, if using [nnm](https://github.com/nvm-sh/nvm), run the following command:

```bash
nvm use
```

### Step 4: Install Nginx

- **Nginx**: Install Nginx by following the instructions on the [Nginx website](https://nginx.org/en/docs/install.html).

```bash
sudo apt install nginx
```

#### Nginx Configuration

Create an Nginx configuration file for your Laravel project:

```bash
sudo nano /etc/nginx/sites-available/crowdsourcing
```

Add the necessary configuration to the file. Refer to the Nginx documentation for detailed configuration.

Example configuration:

```nginx
server {
    listen 80;
    server_name crowdsourcing.local;
    root /var/www/crowdsourcing/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.php index.html index.htm index.nginx-debian.html;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

Enable the configuration:

```bash
sudo ln -s /etc/nginx/sites-available/crowdsourcing /etc/nginx/sites-enabled/

sudo systemctl restart nginx
```

### Step 5: Install MySQL

- **MySQL**: Install MySQL by following the instructions on
  the [MySQL website](https://dev.mysql.com/doc/mysql-installation-excerpt/8.0/en/).

```bash
sudo apt install mysql-server
```

#### Database Considerations

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

## Method 3: Ddev

### Step 1: Install Ddev

- **Ddev**: Install Ddev by following the instructions on the [Ddev website](https://ddev.readthedocs.io/en/stable/).

### Step 2: Start Ddev

Run the following command to start Ddev:

```bash
ddev start
```

## Run the Laravel Application commands

Depending on the installation method, you should run the following commands either in the Docker container or on your
local machine.

For example, if you have already started the Docker containers, you can run the following command to access the PHP
container:

```bash
docker exec -it crowdsourcing-php bash
```

and then run the following commands.

If you are running the commands on your local machine, you can run the following commands directly.

If you have started Ddev, you should run all the commands prefixed with `ddev exec`.

### Step 1: Create the `.env` file

After cloning the project, create an .env file (should be a copy of .env.example):

```bash
cp .env.example .env
```

And then persist the `.env` settings to Laravel Cache:

```bash
php artisan config:cache
```

### Step 2: Generate the application key

```bash
php artisan key:generate
```

### Step 3: Install Laravel (back-end) dependencies

```bash
composer install

composer dump-autoload
```

### Step 4: Install and compile the front-end dependencies:

```bash
npm install

npm run dev # (if in development mode, use for live changes)

npm run build # (if in development mode)

npm run prod # (if in production mode)
```

### Step 5: Set up the Database **(only if in new installation)**

Run the Laravel migrations:

```bash
php artisan migrate
```

Run the Database seeder:

```bash
php artisan db:seed
```

### Step 6: Create symbolic link for uploaded files

By default, images are stored at app/storage/public. Run

```bash
php artisan storage:link
```

in order to link this folder with the public directory

### Step 7: Fix permissions for storage directory

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

And then reference the 2 generated files in the Nginx configuration file of the application.
Make sure you change the port to 443 as shown below:

```nginx
server {
    listen 443 ssl;
    server_name dev.crowdsourcing;

    ssl_certificate /path/to/dev.crowdsourcing.crt;
    ssl_certificate_key /path/to/dev.crowdsourcing.key;

    root /var/www/crowdsourcing/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.php index.html index.htm index.nginx-debian.html;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

Also, make sure to restart Nginx, by running

```bash
sudo systemctl restart nginx
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

## Troubleshooting

If you encounter any issues, refer to the following steps:

1. Check container logs if using Docker Compose: `docker-compose logs`
2. Verify Nginx and PHP-FPM status: `systemctl status nginx` and `systemctl status php-fpm`
3. Review Laravel logs located in `storage/logs/laravel.log`
4. Ensure your `.env` file has the correct database credentials
5. Verify the MySQL service is running: `systemctl status mysql`
6. Check the Nginx configuration: `nginx -t`

## Contributing

To contribute to the application, follow these steps:

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

## Contact

Feel free to contact the project maintainers:

- [SciFY](https://www.scify.org/)
- [ECAS](https://ecas.org/)
