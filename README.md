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
[![GitHub release](https://img.shields.io/github/release/scify/Crowdsourcing-Platform.svg)](https://github.com/scify/Crowdsourcing-Platform/releases/tag/v8.0)

## Introduction

This is a [Laravel](https://laravel.com/) Web Application for Crowdsourcing Projects and Questionnaires.

## Table of Contents

- [Crowdsourcing Web Application](#crowdsourcing-web-application)
    - [Introduction](#introduction)
    - [Table of Contents](#table-of-contents)
    - [Features](#features)
    - [Benefits of Open Source applications](#benefits-of-open-source-applications)
    - [Organizations using the Crowdsourcing platform](#organizations-using-the-crowdsourcing-platform)
    - [Setup Instructions](#setup-instructions)
    - [Run the Laravel Application commands](#run-the-laravel-application-commands)
        - [Step 1: Fix permissions for storage directory](#step-1-fix-permissions-for-storage-directory)
        - [Step 2: Create the `.env` file](#step-2-create-the-env-file)
        - [Step 3: Create A Database](#step-3-create-a-database)
            - [Add the DB schema and the DB data](#add-the-db-schema-and-the-db-data)
                - [Option 1: Use an existing database (MySQL dump)](#option-1-use-an-existing-database-mysql-dump)
                - [Option 2: Run the migrations and seed the database](#option-2-run-the-migrations-and-seed-the-database)
        - [Step 4: Install Laravel (back-end) dependencies](#step-4-install-laravel-back-end-dependencies)
        - [Step 5: Generate the application key](#step-5-generate-the-application-key)
        - [Step 6: Install and compile the front-end dependencies:](#step-6-install-and-compile-the-front-end-dependencies)
        - [Step 7: Create symbolic link for uploaded files](#step-7-create-symbolic-link-for-uploaded-files)
        - [Step 8: Cache the `.env` settings](#step-8-cache-the-env-settings)
    - [Social Login - Sign Up with Socialite](#social-login---sign-up-with-socialite)
        - [Nginx Configuration for Social Login (only for Non-Docker installations)](#nginx-configuration-for-social-login-only-for-non-docker-installations)
    - [SEO - Generate Sitemap](#seo---generate-sitemap)
    - [Code Linting \& Formatting](#code-linting--formatting)
        - [PHP code style - Laravel Pint](#php-code-style---laravel-pint)
        - [JavaScript \&\& CSS code style - ESLint \&\& Prettier](#javascript--css-code-style---eslint--prettier)
    - [Related HTML Template](#related-html-template)
    - [Installation-specific resources](#installation-specific-resources)
    - [Development Guidelines](#development-guidelines)
        - [Directory Structure](#directory-structure)
        - [About the Repository Pattern](#about-the-repository-pattern)
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

## Organizations using the Crowdsourcing platform

[ECAS official installation](https://crowdsourcing.ecas.org/en)

[SciFY official installation](https://crowdsourcing.scify.org/)

## Setup Instructions

The setup instructions have been divided into two sections for clarity:

- [Docker-based Setup (recommended)](./setup-docker.md)
- [Non-Docker Setup](./setup-non-docker.md)

## Run the Laravel Application commands

Regardless of the installation method, you will need to run the following commands to set up the application.

### Step 1: Fix permissions for storage directory

These commands should be run **outside** any Docker container:

```bash
sudo chown -R `whoami`:www-data storage

chmod 775 storage

cd storage/

find . -type f -exec chmod 664 {} \;

find . -type d -exec chmod 775 {} \;
```

Depending on the installation method, you should run the rest of the steps either in the Docker container or on your
local machine.

**Note:** If you are using Docker Compose, you will first need first to enter the PHP container:

```bash
docker exec -it crowdsourcing_platform_server bash
```

and then run the rest of the commands.

If you are running the commands on your local machine, you can run the following commands directly.

If you have started Ddev, you should run all the commands prefixed with `ddev exec`.

### Step 2: Create the `.env` file

After cloning the project, create an .env file (should be a copy of .env.example):

```bash
cp .env.example .env
```

### Step 3: Create A Database

In case of a non-Docker installation, you will need to create a Database for the application.

In case of a Docker environment, enter the `crowdsourcing_platform_db` container, and create a Database
named `crowdsourcing_db_docker`:

```bash
docker exec -it crowdsourcing_platform_db bash
```

Enter the MySQL shell:

```bash
mysql -u root -p
```

Then, run the following MySQL command:

```mysql
CREATE DATABASE IF NOT EXISTS crowdsourcing_db_docker;
```

#### Add the DB schema and the DB data

##### Option 1: Use an existing database (MySQL dump)

First you will need to enter the DB container:

```bash
docker exec -it crowdsourcing_platform_db bash
```

If you have an existing MySQL dump file, make sure that is in the current directory, and import it into the database:

```bash
mysql -u root -p crowdsourcing_db_docker < dump.sql
```

Then, add the following to the `.env` file:

```bash
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=crowdsourcing_db_docker
DB_USERNAME=root
DB_PASSWORD=root
```

##### Option 2: Run the migrations and seed the database

**Note:** If you are using Docker Compose, you will need first to enter the **server** container:

```bash
docker exec -it crowdsourcing_platform_server bash
```

1. Run the Laravel migrations:

```bash
php artisan migrate
```

2. Run the Database seeder:

```bash
php artisan db:seed
```

### Step 4: Install Laravel (back-end) dependencies

Enter the PHP container (if using Docker Compose):

```bash
docker exec -it crowdsourcing_platform_server bash
```

Then, run the following commands:

```bash
composer install

composer dump-autoload
```

### Step 5: Generate the application key

```bash
php artisan key:generate
```

### Step 6: Install and compile the front-end dependencies:

```bash
npm install

npm run dev # (if in development mode, use for live changes)

npm run build # (if in development mode)

npm run prod # (if in production mode)
```

### Step 7: Create symbolic link for uploaded files

By default, images are stored at app/storage/public. Run

```bash
php artisan storage:link
```

### Step 8: Cache the `.env` settings

And then persist the `.env` settings to Laravel Cache:

```bash
php artisan config:cache
```

in order to link this folder with the public directory

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

### Nginx Configuration for Social Login (only for Non-Docker installations)

Reference the 2 generated files in the Nginx configuration file of the application.
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

## Code Linting & Formatting

### PHP code style - Laravel Pint

This application uses [Laravel Pint](https://laravel.com/docs/9.x/pint) in order to perform code-style.

In order to run the styler, run :

```bash
./vendor/bin/pint --test -v # the --test will not do any changes, it will just output the changes needed

./vendor/bin/pint -v # this command will actually perform the code style changes 
```

### JavaScript && CSS code style - ESLint && Prettier

This application uses [ESLint](https://eslint.org/) and [Prettier](https://prettier.io/) in order to perform code-style.

In order to run the styler & formatter, run :

```bash
npm run lint # this command will check the code style

npm run format # this command will format the code style
```

## Related HTML Template

This project uses the free [AdminLTE](https://adminlte.io/docs/3.0/) template.

It also makes use of [Bootstrap 4](https://getbootstrap.com/docs/4.4/getting-started/introduction/)

## Installation-specific resources

The application can be tweaked and personalized for each installation.
In the `.env` file you can set the `INSTALLATION_RESOURCES_DIR` variable accordingly. This variable must take a value
that represents a directory name in the `resourcess/views/home/partials` directory. For example, see
the `resourcess/views/home/partials/together` directory. This directory must contain the partial blade files for the
installation.

## Development Guidelines

### Directory Structure

This part of the documentation describes the directory structure of the Laravel application.

It is mostly scoped to the custom directories and files that are used in the application. For the general Laravel
directory structure, please refer to the [official documentation](https://laravel.com/docs/11.x/structure).

```text
├── app                         # Laravel application directory
│   ├── BusinessLogicLayer      # Business Logic Layer classes (services that contain the business logic and delegate from Controllers towards the Data Access Layer)  
│   ├── Http/Controllers        # Controllers directory (classes that handle the HTTP requests, perform the necessary validations/operations and return the responses)
│   ├── Http/Middleware         # Middleware directory (classes that handle the HTTP requests before they reach the Controllers)
│   ├── Models                  # Models directory (ORM classes that represent the database tables and contain the relationships between them)
│   ├── Notifications           # Notifications directory (classes that handle the notifications, like emails)
│   ├── ViewModels              # View Models directory (classes that contain the data that will be passed to the views)
│   ├── Repository              # Repository directory (classes that handle the database operations and contain the DB/ORM queries)
│   resources                   # Resources directory (contains the views, assets, front-end files, and other resources)
│   ├── views                   # Views directory (contains the blade files that are used to render the HTML)
│   ├── assets                  # Assets directory (contains the front-end assets like CSS, JS, images, etc.)
│       ├── js                  # JavaScript files (contains the Vue.js components and other JS files)
│       ├── sass                # SASS files (contains the SASS files that are compiled to CSS)
│   ├── lang                    # Language files (contains the language files for the translations)
```

### About the Repository Pattern

The application uses the Repository Pattern to separate the business logic from the data access logic.

All the database operations are handled by the Repository classes, which contain the DB/ORM queries.

These classes are located in the `app/Repository` directory, and they all extend the `app/Repository/Repository` class.

Each child class represents a database table/entity and contains the queries for that table. This entity is defined in
the `app/Models` directory, and is referenced by the child Repository class, in the `getModelClassName` method.

So, we can use the base methods that are defined in the `Repository` class, like `getAll`, `getById`, `create`,
`update`, without having to write the same queries in each child class. We can also define custom queries in the child
classes, or override the base methods if needed.

The Repository classes are used by the Business Logic Layer classes, which contain the business logic and delegate from
the Controllers towards the Data Access Layer.

More information about the Repository Pattern can be
found [here](https://designpatternsphp.readthedocs.io/en/latest/More/Repository/README.html).

## Run Tests

### Before running the tests

Make sure that you have cleared any cache and config files:

```bash
php artisan cache:clear

php artisan config:clear
```

Then, make sure that you have set up the test database:

First you need to run the migrations for the test database:

```bash
  php artisan migrate --env=testing --database=sqlite_testing
```

Then run the seeders for the test database:

```bash
  php artisan db:seed --env=testing --database=sqlite_testing
```

### PHPUnit with the `php artisan test` command

You can run the tests using the `php artisan test` command, which is a built-in Laravel command.

And finally, run the tests:

```bash
  # Note that you filter the tests by using the --filter flag (without the = sign)
  php artisan test --env=testing --filter {METHOD OR CLASS NAME} --coverage
```

## How to debug

By using Docker Compose, you can debug the application by following these steps:

1. Run `docker compose up` to start the containers.
2. In VSCode, open the project directory and install the PHP Debug extension.
3. For the PHP Debug extension, make sure that you have a `.vscode/launch.json` file with the following contents:

```json
{
  "version": "0.2.0",
  "configurations": [
    {
      "name": "Listen for Xdebug",
      "type": "php",
      "request": "launch",
      "port": 9003,
      "pathMappings": {
        "/var/www": "${workspaceFolder}"
      },
      "log": true
    }
  ]
}
```

4. Start the debugger by navigating to the "Run and Debug" panel, and clicking on the "Listen for Xdebug" configuration.
5. Set breakpoints in your code.

Now you can start debugging your application.

For debugging the tests:

1. Open the test file you want to debug.
2. Add breakpoints in the test file.
3. Run `docker exec -it crowdsourcing_platform_server bash` to enter the PHP container.
4. Run `php artisan app:test --filter {METHOD OR CLASS NAME}`. For example
   `php artisan app:test --filter authenticatedNonAdminUserCannotAccessCreatePage`.

## Troubleshooting

If you encounter any issues, refer to the following steps:

1. Check container logs if using Docker Compose: `docker compose logs`
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

Some of the images used in the application are from [Freepik](https://www.freepik.com/).

## Contact

Feel free to contact the project maintainers:

- [SciFY](https://www.scify.org/)
- [ECAS](https://ecas.org/)
