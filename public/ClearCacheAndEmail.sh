source clearCache.sh
php artisan queue:restart
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl restart laravel-estagios-worker:*
