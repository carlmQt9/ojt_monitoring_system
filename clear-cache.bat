@echo off
REM Clear Laravel caches and refresh browser
echo Clearing Laravel caches...
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:cache
echo ✓ Caches cleared! Refresh your browser now (Ctrl+F5)
pause
