FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    libzip-dev \
    libonig-dev \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl zip gd bcmath
RUN docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-freetype=/usr/include/
RUN docker-php-ext-install gd

# Install composer
RUN apt update && apt install -y curl
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install node
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

# Install yarn
RUN npm install --global yarn

# Set working directory
WORKDIR /var/www

# Remove default nginx webpage
RUN rm -rf /var/www/html

# Create a non-root user
RUN useradd -ms /bin/bash newuser

# Change the ownership of the /var/www directory to newuser
RUN chown -R newuser:newuser /var/www

USER newuser

COPY --chown=newuser:newuser . /var/www
COPY --chown=newuser:newuser .env.dev /var/www/.env

# Install composer dependencies
RUN composer install


RUN rm -rf node_modules
RUN rm package-lock.json
RUN rm yarn.lock

# Build Vue files
RUN yarn install
RUN yarn build

# Change current user to www
USER root
RUN chown -R www-data:www-data /var/www
USER www-data

# Start project
CMD php artisan serve --host=0.0.0.0 --port=8080

EXPOSE 8080
