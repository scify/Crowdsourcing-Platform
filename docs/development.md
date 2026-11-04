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
[official documentation](https://laravel.com/docs/13.x/structure).

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

Two Composer scripts run all the checks together. With DDEV, prefix them with
`ddev`, for example `ddev composer lint:check`:

```bash
composer lint:check # Pint, Rector, Larastan, ESLint and Prettier, all check only; the same checks as CI
composer lint:fix   # Pint, ESLint --fix and Prettier, then Larastan
composer analyse    # Larastan only
```

The sections below describe the individual tools.

### PHP — Laravel Pint

The application uses [Laravel Pint](https://laravel.com/docs/13.x/pint) for the
PHP code style:

```bash
./vendor/bin/pint --test -v # check only: reports the needed changes
./vendor/bin/pint -v        # apply the code style changes
```

### JavaScript & CSS — ESLint & Prettier

The application uses [ESLint](https://eslint.org/) and
[Prettier](https://prettier.io/):

```bash
npm run lint         # check the code style (ESLint)
npm run format:check # check the formatting (Prettier)
npm run check        # both checks; CI runs this script
npm run format       # format the code
```

Prettier formats `resources/assets/`, `vite.config.mjs` and `eslint.config.js`.
It does not format `composer.json` and `composer.lock`, because Composer writes
those files in its own format.

The Husky pre-commit hooks run ESLint and Prettier automatically: Prettier
formats the staged `.js`, `.mjs`, `.vue`, `.scss` and `.css` files and stages
the result again.

## Run the tests

The tests run on a seeded SQLite file (`storage/database_testing.sqlite`,
connection `sqlite_testing`). The Composer scripts clear the config cache,
create and seed that file, and then run the suite. With DDEV, prefix them with
`ddev`, for example `ddev composer test`:

```bash
composer test                               # the full suite
composer test -- --filter={METHOD OR CLASS} # extra arguments go to artisan test
composer test:coverage                      # with coverage and the CI minimum
```

`composer test:coverage` needs Xdebug or PCOV. In DDEV, run `ddev xdebug on`
first, and `ddev xdebug off` afterwards.

Every test runs inside a database transaction that rolls back
(`DatabaseTransactions` on the base `TestCase`), so the seeded test database
stays pristine. After the first `composer test`, you can also run
`php artisan test --env=testing` directly; it skips the database rebuild.

### Coverage ratchet

CI runs the suite with `--coverage --min=48`, so the build fails if line
coverage drops below the floor. When you raise coverage, raise the ratchet by
bumping `--min` in the `test:coverage` script in `composer.json`.

Coverage is uploaded to [Codecov](https://codecov.io/github/scify/Crowdsourcing-Platform)
on every CI run, which powers the README badge and per-PR coverage reports.

## How to debug

With DDEV, you can debug the application with Xdebug and VSCode:

1. Run `ddev xdebug on`. Xdebug slows PHP down, so run `ddev xdebug off` when you are done.
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
        "/var/www/html": "${workspaceFolder}"
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
2. Run `ddev composer test -- --filter={METHOD OR CLASS NAME}`. For example
   `ddev composer test -- --filter=authenticatedNonAdminUserCannotAccessCreatePage`.

## Troubleshooting

For a DDEV installation, see the troubleshooting section of
[setup-ddev.md](./setup-ddev.md#troubleshooting). For a manual installation,
see [setup-manual.md](./setup-manual.md#troubleshooting).
