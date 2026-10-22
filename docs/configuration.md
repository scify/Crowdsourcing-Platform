# Configuration

## Social Login — Sign in with Socialite

The app uses [Laravel Socialite](https://laravel.com/docs/13.x/socialite) to
handle social login (Facebook, Google, LinkedIn, Twitter/X).

To get it working in your development environment:

1. Create API keys and secrets for each provider in their developer consoles,
   and set them in `.env` (see `config/services.php` for the expected
   variables).
2. Most providers require an HTTPS callback URL. Generate a local self-signed
   certificate:

```bash
openssl req -new -sha256 -newkey rsa:2048 -nodes \
-keyout dev.crowdsourcing.key -x509 -days 365 \
-out dev.crowdsourcing.crt
```

A guide for enabling HTTPS on your local machine can be found
[here](https://deliciousbrains.com/https-locally-without-browser-privacy-errors/).

### Nginx configuration for HTTPS (non-Docker installations)

Reference the two generated files in the Nginx configuration of the
application, and change the port to 443:

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
        # match your installed PHP version
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

Restart Nginx afterwards:

```bash
sudo systemctl restart nginx
```

## SEO — Generate the sitemap

The application uses the
[Spatie Laravel Sitemap](https://github.com/spatie/laravel-sitemap) package to
create the `public/sitemap.xml` file (excluded from git), which is crawled by
the search engines. Generate it for the current installation with:

```bash
php artisan sitemap:generate
```

## Installation-specific resources

The application can be tweaked and personalized for each installation. In the
`.env` file, set the `INSTALLATION_RESOURCES_DIR` variable to a directory name
inside `resources/views/home/partials`. For example, see the
`resources/views/home/partials/together` directory. This directory must contain
the partial blade files for the installation.
