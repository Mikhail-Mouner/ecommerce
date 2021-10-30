#php artisan migrate:fresh --seed
#composer dumpautoload
php artisan clear-compiled
php artisan view:clear
php artisan cache:clear
php artisan config:cache
php artisan route:clear
redis-cli
FLUSHALL
exit
#php artisan route:cache
PAUSE
