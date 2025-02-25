FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    intl \
    opcache \
    pdo \
    pdo_mysql \
    gd \
    zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

COPY . /var/www

#RUN curl -sS https://get.symfony.com/cli/installer | bash && \
 #   mv /root/.symfony/bin/symfony /usr/local/bin/symfony

#RUN chown -R www-data:www-data /var/www/html \
 #   && chmod -R 777 /var/www/html/var



RUN composer install

EXPOSE 9000

#RUN composer install
#RUN php bin/console doctrine:database:create --if-not-exists --no-interaction
#RUN php bin/console doctrine:migrations:migrate --no-interaction
#RUN php bin/console cache:clear --no-interaction