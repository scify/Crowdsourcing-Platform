# Development Guidelines

## Front-end stack

The back-office uses a custom admin shell built on
[Bootstrap 5](https://getbootstrap.com/docs/5.3/getting-started/introduction/),
along with [Vue 3](https://vuejs.org/), [SurveyJS](https://surveyjs.io/), and
[DataTables](https://datatables.net/). Assets are compiled with
[Vite](https://vitejs.dev/).

## Directory structure

This section describes the custom directories of the application. For the
general Laravel directory structure, refer to the
[official documentation](https://laravel.com/docs/12.x/structure).

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

## About the Repository Pattern

The application uses the Repository Pattern to separate the business logic from
the data access logic.

All the database operations are handled by the Repository classes, which
contain the DB/ORM queries. These classes are located in the `app/Repository`
directory, and they all extend the `app/Repository/Repository` class.

Each child class represents a database table/entity and contains the queries
for that table. This entity is defined in the `app/Models` directory, and is
referenced by the child Repository class, in the `getModelClassName` method.

So, we can use the base methods that are defined in the `Repository` class,
like `getAll`, `getById`, `create`, `update`, without having to write the same
queries in each child class. We can also define custom queries in the child
classes, or override the base methods if needed.

The Repository classes are used by the Business Logic Layer classes, which
contain the business logic and delegate from the Controllers towards the Data
Access Layer.

More information about the Repository Pattern can be found
[here](https://designpatternsphp.readthedocs.io/en/latest/More/Repository/README.html).

## Code linting & formatting

### PHP — Laravel Pint

The application uses [Laravel Pint](https://laravel.com/docs/12.x/pint) for the
PHP code style:

```bash
./vendor/bin/pint --test -v # check only: reports the needed changes
./vendor/bin/pint -v        # apply the code style changes
```

### JavaScript & CSS — ESLint & Prettier

The application uses [ESLint](https://eslint.org/) and
[Prettier](https://prettier.io/):

```bash
npm run lint   # check the code style
npm run format # format the code
```

Both run automatically on staged files through the Husky pre-commit hooks.

## Run the tests

### Before running the tests

Clear any cache and config files:

```bash
php artisan cache:clear
php artisan config:clear
```

Create the test database file and give it the necessary permissions:

```bash
touch storage/database_testing.sqlite
chmod 777 storage/database_testing.sqlite
```

Run the migrations and seeders for the test database:

```bash
php artisan migrate:fresh --seed --env=testing --database=sqlite_testing
```

### Run the tests with `php artisan test`

```bash
# Filter the tests with the --filter flag (without the = sign)
XDEBUG_MODE=coverage php artisan test --env=testing --filter {METHOD OR CLASS NAME} --coverage
```

### Run the tests with the `run-tests.sh` script

The `run-tests.sh` script is a wrapper around the PHPUnit command:

```bash
chmod +x run-tests.sh
./run-tests.sh
./run-tests.sh --filter {METHOD OR CLASS NAME}
XDEBUG_MODE=coverage ./run-tests.sh --coverage
```

## How to debug

With Docker Compose, you can debug the application with Xdebug and VSCode:

1. Run `docker compose up` to start the containers.
2. In VSCode, open the project directory and install the PHP Debug extension.
3. Make sure that you have a `.vscode/launch.json` file with the following
   contents:

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

4. Start the debugger in the "Run and Debug" panel with the "Listen for Xdebug"
   configuration.
5. Set breakpoints in your code.

For debugging the tests:

1. Open the test file you want to debug and add breakpoints.
2. Run `docker exec -it crowdsourcing_platform_server bash` to enter the PHP
   container.
3. Run `php artisan app:test --filter {METHOD OR CLASS NAME}`. For example
   `php artisan app:test --filter authenticatedNonAdminUserCannotAccessCreatePage`.

## Troubleshooting

1. Check container logs if using Docker Compose: `docker compose logs`
2. Verify the Nginx and PHP-FPM status: `systemctl status nginx` and `systemctl status php-fpm`
3. Review the Laravel logs located in `storage/logs/laravel.log`
4. Ensure your `.env` file has the correct database credentials
5. Verify the MySQL service is running: `systemctl status mysql`
6. Check the Nginx configuration: `nginx -t`
