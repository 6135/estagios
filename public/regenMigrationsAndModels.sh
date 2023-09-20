rm -rf /var/www/estagiosadminv2.dei.uc.pt/public/database/migrations
rm -rf /var/www/estagiosadminv2.dei.uc.pt/public/app/Models
mkdir /var/www/estagiosadminv2.dei.uc.pt/public/database/migrations 

cd /var/www/estagiosadminv2.dei.uc.pt/public

php artisan migrate:generate --skip-proc --with-has-table
chown gui:www-data -R /var/www/estagiosadminv2.dei.uc.pt/public/database/migrations
source clearCache.sh
php artisan code:models
chown gui:www-data -R /var/www/estagiosadminv2.dei.uc.pt/public/app/Models

php artisan queue:batches-table
php artisan queue:failed-table
php artisan queue:table
php artisan migrate
