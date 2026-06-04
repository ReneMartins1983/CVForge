#!/usr/bin/env sh
set -e

# Banco SQLite (efêmero — recriado a cada deploy/restart, ok para demo)
touch /var/www/database/database.sqlite
php artisan migrate --force --seed
php artisan storage:link || true

# Otimizações de produção
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Render injeta a porta em $PORT
php artisan serve --host 0.0.0.0 --port "${PORT:-8000}"
