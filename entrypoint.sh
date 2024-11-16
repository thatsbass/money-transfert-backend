#!/bin/bash

# Stop the script on any error
set -e

# Attendre que Redis soit prêt
# until nc -z redis 6379; do
#   echo "Attente de Redis..."
#   sleep 2
# done

if [ "$RUN_MIGRATIONS" = "true" ]; then
  echo "Running migrations..."
  php artisan migrate --force
fi

echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan optimize:clear

echo "Starting the queue worker..."
php artisan queue:work --verbose --tries=3 --timeout=90 &

echo "Starting the Laravel server..."
exec php artisan serve --host=0.0.0.0 --port=8000
