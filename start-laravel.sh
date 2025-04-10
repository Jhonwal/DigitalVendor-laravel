#!/bin/bash

# Install dependencies if needed
if [ ! -d "vendor" ]; then
  composer install
fi

# Create storage link if needed
if [ ! -L "public/storage" ]; then
  php artisan storage:link
fi

# Generate the application key if not already set
if ! grep -q "APP_KEY=" .env; then
  php artisan key:generate
fi

# Ensure SQLite database exists
touch database/database.sqlite
chmod 777 database/database.sqlite
chmod 777 database

# Run database migrations
php artisan migrate --force

# Start the Laravel development server
php artisan serve --host=0.0.0.0 --port=3000