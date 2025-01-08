#!/bin/bash

# Clear the cache
php artisan cache:clear

# Clear the config cache
php artisan config:clear

# Create a new database for testing
touch storage/database_testing.sqlite

# Run the migrations and seed the database for testing
php artisan migrate:fresh --seed --env=testing --database=sqlite_testing

# Run the tests with any additional arguments passed to the script
php artisan test --env=testing "$@"