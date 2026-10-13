#!/bin/bash
set -e

# Đảm bảo file SQLite tồn tại nếu dùng SQLite
if [ "$DB_CONNECTION" = "sqlite" ]; then
    DB_FILE="${DB_DATABASE:-/var/www/html/database/database.sqlite}"
    if [ ! -f "$DB_FILE" ]; then
        touch "$DB_FILE"
        chown www-data:www-data "$DB_FILE"
        chmod 664 "$DB_FILE"
    fi
fi

# Chạy migrate và cache cấu hình
php artisan migrate --force || true
php artisan storage:link || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Khởi chạy Apache ở foreground
exec apache2-foreground
