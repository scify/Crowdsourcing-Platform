# Docker-Based Setup (recommended)

This guide is self-contained: follow it from top to bottom to get a working
development installation with Docker Compose.

## Prerequisites

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Node.js and npm](https://nodejs.org/) on your host machine (Node >= 24, npm >= 11 — see `package.json` `engines`), for compiling the front-end assets

## 1. Clone the repository

```bash
git clone https://github.com/scify/Crowdsourcing-Platform.git
cd Crowdsourcing-Platform
```

## 2. Fix permissions for the storage directory

Run these commands **on your host machine**, from the project root:

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

Set the database credentials in `.env` (the `db` host is the Docker Compose service):

```dotenv
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=crowdsourcing_db_docker
DB_USERNAME=root
DB_PASSWORD=root
```

## 4. Build and start the containers

```bash
docker compose up --build
```

- Application: [http://localhost:89](http://localhost:89)
- PHPMyAdmin: [http://localhost:8081](http://localhost:8081)

## 5. Create the database

Enter the database container and create the database:

```bash
docker exec -it crowdsourcing_platform_db bash
mysql -u root -p
```

```mysql
CREATE DATABASE IF NOT EXISTS crowdsourcing_db_docker;
```

## 6. Install the back-end dependencies

All the remaining PHP commands run **inside the server container**:

```bash
docker exec -it crowdsourcing_platform_server bash
```

Then:

```bash
composer install
composer dump-autoload
```

## 7. Generate the application key

```bash
php artisan key:generate
```

## 8. Add the database schema and data

Choose one of the two options.

**Option 1 — import an existing MySQL dump.** Inside the **db** container, with
the dump file in the current directory:

```bash
mysql -u root -p crowdsourcing_db_docker < dump.sql
```

**Option 2 — run the migrations and seed the database.** Inside the **server**
container:

```bash
php artisan migrate
php artisan db:seed
```

## 9. Install and compile the front-end assets

On your **host machine**:

```bash
npm install
npm run dev    # development mode with live changes
npm run build  # one-off development build
npm run prod   # production build
```

## 10. Create the symbolic link for uploaded files

Uploaded images are stored at `storage/app/public`. Link that directory to
`public/storage` (inside the server container):

```bash
php artisan storage:link
```

## 11. Cache the configuration

```bash
php artisan config:cache
```

Re-run this command every time you change the `.env` file.

## Troubleshooting

1. Check the container logs: `docker compose logs`
2. Review the Laravel logs at `storage/logs/laravel.log`
3. Verify that the `.env` database credentials match step 3

For development guidelines (tests, linting, debugging), see
[development.md](./development.md).
