#!/bin/bash

echo "Running migrations and seeding database ..."
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan optimize:clear
php artisan optimize

echo "Starting Laravel server ..."
php artisan serve --host=0.0.0.0 --port=$PORT