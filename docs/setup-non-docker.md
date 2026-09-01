# Non-Docker Setup

This guide is self-contained: follow it from top to bottom to get a working
development installation directly on your machine.

## Prerequisites

- PHP 8.3 or newer
- [Composer](https://getcomposer.org/)
- [Node.js and npm](https://nodejs.org/) (Node >= 24, npm >= 11 — see `package.json` `engines`), preferably managed by NVM
- MySQL
- Nginx (optional — `php artisan serve` also works for development)

## 1. Clone the repository

```bash
git clone https://github.com/scify/Crowdsourcing-Platform.git
cd Crowdsourcing-Platform
```

## 2. Fix permissions for the storage directory

```bash
sudo chown -R `whoami`:www-data storage
chmod 775 storage
find storage -type f -exec chmod 664 {} \;
find storage -type d -exec chmod 775 {} \;
```

## 3. Create the `.env` file

```bash
cp .env.example .env
```

## 4. Create the database and configure `.env`

Create a MySQL database for the application, then set the credentials in `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crowdsourcing
DB_USERNAME=your_user
DB_PASSWORD=your_password
```

### MySQL 8 note: sort buffer size

MySQL 8.0+ has a [bug](https://bugs.mysql.com/bug.php?id=103465) that causes a
memory overflow when sorting results in tables with JSON columns. Work around
it by increasing the sort buffers:

```bash
sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf
```

```ini
[mysqld]
sort_buffer_size = 10485760
innodb_sort_buffer_size = 10485760
```

```bash
sudo service mysql restart
```

## 5. Install the back-end dependencies

```bash
composer install
composer dump-autoload
```

## 6. Generate the application key

```bash
php artisan key:generate
```

## 7. Add the database schema and data

Choose one of the two options.

**Option 1 — import an existing MySQL dump:**

```bash
mysql -u your_user -p crowdsourcing < dump.sql
```

**Option 2 — run the migrations and seed the database:**

```bash
php artisan migrate
php artisan db:seed
```

## 8. Install and compile the front-end assets

```bash
npm install
npm run dev    # development mode with live changes
npm run build  # one-off development build
npm run prod   # production build
```

## 9. Create the symbolic link for uploaded files

Uploaded images are stored at `storage/app/public`. Link that directory to
`public/storage`:

```bash
php artisan storage:link
```

## 10. Cache the configuration

```bash
php artisan config:cache
```

Re-run this command every time you change the `.env` file.

## 11. Serve the application

For development, the built-in server is enough:

```bash
php artisan serve
```

### Chrome forces HTTPS on `http://localhost`

Google Chrome may force the HTTPS protocol on localhost. If that happens, open
[chrome://net-internals/#hsts](chrome://net-internals/#hsts) and enter
`localhost` in the **Delete domain security policies** field.

## Nginx configuration (optional)

For a server-style installation, create an Nginx site:

```bash
sudo nano /etc/nginx/sites-available/crowdsourcing
```

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
        # match your installed PHP version
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

```bash
sudo ln -s /etc/nginx/sites-available/crowdsourcing /etc/nginx/sites-enabled/
sudo systemctl restart nginx
```

## Troubleshooting

1. Verify the Nginx and PHP-FPM status: `systemctl status nginx` and `systemctl status php8.3-fpm`
2. Review the Laravel logs at `storage/logs/laravel.log`
3. Ensure the `.env` file has the correct database credentials
4. Verify that the MySQL service runs: `systemctl status mysql`
5. Check the Nginx configuration: `nginx -t`

For development guidelines (tests, linting, debugging), see
[development.md](./development.md).
