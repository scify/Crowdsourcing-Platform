# Non-Docker Setup Instructions

## Prerequisites

- PHP 8.2 or newer
- Composer
- Node.js and npm (preferable managed by NVM)
- MySQL
- Nginx

---

## Nginx Configuration

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

---

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

---

## Steps

1. Clone the repository:
    ```bash
    git clone https://github.com/scify/Crowdsourcing-Platform.git
    cd Crowdsourcing-Platform
    ```

2. Install dependencies:
    ```bash
    composer install
    npm install
    ```

3. Set up environment variables:
    ```bash
    cp .env.example .env
    ```

4. Create a database and configure `.env`.

5. Run Laravel commands:
    ```bash
    php artisan migrate
    php artisan db:seed
    php artisan key:generate
    php artisan storage:link
    ```

6. Serve the application:
    ```bash
    php artisan serve
    ```
7. Live reload for front-end assets:
    ```bash
    npm run dev
    ```

## Note: `http` on Chrome

**Notice:** On Google Chrome, the browser might force the HTTPS protocol. In this case, you need to access the Chrome
settings at [chrome://net-internals/#hsts](chrome://net-internals/#hsts), and enter `localhost` in the `Delete domain security policies
` field.

Refer to the main README for additional details.
