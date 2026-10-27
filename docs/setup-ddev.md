# DDEV Setup (recommended)

This guide is self-contained: follow it from top to bottom to get a working
development installation with [DDEV](https://ddev.com/).

The DDEV project (`.ddev/`) provides:

| Service | Details |
|---------|---------|
| Web | PHP 8.3 with nginx-fpm, at <https://crowdsourcing-platform.ddev.site> |
| Database | MySQL 8.4 (host `db`, database/user/password `db`) |
| Redis | `ddev/ddev-redis` add-on (host `redis`) |
| Email | Mailpit catches all outgoing email (`ddev mailpit`) |
| Node.js | The version from `.nvmrc`, inside the web container |
| Vite | Dev server on port 5173 (`ddev npm run dev`) |

You do not need PHP, Composer, MySQL or Node.js on your host machine.

## Prerequisites

- [DDEV](https://ddev.readthedocs.io/en/stable/users/install/ddev-installation/) and a Docker provider that DDEV supports

## 1. Clone the repository

```bash
git clone https://github.com/scify/Crowdsourcing-Platform.git
cd Crowdsourcing-Platform
```

## 2. Create the `.env` file

```bash
cp .env.example .env
```

The defaults in `.env.example` already point to the DDEV services. On every
`ddev start`, DDEV also writes the `APP_URL`, `DB_*` and `MAIL_*` values into
`.env`.

## 3. Start the project

```bash
ddev start
```

## 4. Install the dependencies and build the assets

```bash
ddev composer setup
```

This Composer script installs the PHP dependencies, installs the npm
dependencies when `package-lock.json` changed, generates `APP_KEY` if it is
empty, and builds the front-end assets. You can run it again at any time.

## 5. Add the database schema and data

Choose one of the two options.

**Option 1 — run the migrations and seed the database:**

```bash
ddev artisan migrate --seed
```

The seeded administrator is `platform-admin@crowd.com`, with the password from
`DEFAULT_ADMIN_USER_PASSWORD_FOR_SEED` in `.env`.

**Option 2 — import an existing MySQL dump** (plain or gzipped):

```bash
ddev import-db --file=dump.sql.gz
```

## 6. Create the symbolic link for uploaded files

Uploaded images are stored at `storage/app/public`. Link that directory to
`public/storage`:

```bash
ddev artisan storage:link
```

## 7. Start the Vite dev server

```bash
ddev npm run dev    # Vite dev server with hot reload
```

Without the dev server, the app uses the assets that `ddev composer setup` (or
`ddev npm run build`) built.

Open <https://crowdsourcing-platform.ddev.site> (or run `ddev launch`).

## Everyday commands

| Task | Command |
|------|---------|
| Start / stop the project | `ddev start` / `ddev stop` |
| Run an artisan command | `ddev artisan <command>` |
| Open a shell in the web container | `ddev ssh` |
| Run the tests | `ddev composer test` |
| Check code style and static analysis | `ddev composer lint:check` |
| Fix code style | `ddev composer lint:fix` |
| Process queued jobs | `ddev artisan queue:work` |
| Open a MySQL shell | `ddev mysql` |
| See the caught emails | `ddev mailpit` |
| Enable / disable Xdebug | `ddev xdebug on` / `ddev xdebug off` |
| Show URLs, ports and credentials | `ddev describe` |

After you change `.env`, run `ddev artisan config:clear`.

## Git hooks

The Husky pre-commit hooks run ESLint, Prettier and Pint through
`.husky/run-tool`. If the DDEV project is running, the tools run inside the web
container. Otherwise, they run with your local toolchain.

## Troubleshooting

1. Check the service logs: `ddev logs` (web) or `ddev logs -s db`
2. Review the Laravel logs in `storage/logs/`
3. Check the project state and URLs: `ddev describe`
4. If the page loads without styles, make sure that `ddev npm run dev` is running, or run `ddev npm run build` and delete `public/hot`

For development guidelines (tests, linting, debugging), see
[development.md](./development.md).
