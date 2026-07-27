FROM php:8.4-cli

WORKDIR /var/www


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader


COPY . .


RUN composer dump-autoload \
    --optimize


RUN php artisan package:discover --ansi


CMD ["php","artisan","serve","--host=0.0.0.0"]