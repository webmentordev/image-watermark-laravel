# VPS Deployment Steps (DigitalOcean's Droplet)

1. Link Storage
2. Install imagemagick and php-imagick package in sequence  
sudo apt install imagemagick php-imagick
3. Install Node & NPM on the server
4. Change ownership & pwemissions

sudo chown -R larasail:larasail /var/www/laravel

sudo chown -R larasail:www-data /var/www/laravel/storage

sudo chown -R larasail:www-data /var/www/laravel/bootstrap/cache


sudo find /var/www/laravel -type d -exec chmod 755 {} \;

sudo find /var/www/laravel -type f -exec chmod 644 {} \;

sudo chmod -R 775 /var/www/laravel/storage /var/www/laravel/bootstrap/cache  
**If NPM command cause problem for permissions**

sudo chmod -R 755 /var/www/laravel/node_modules
