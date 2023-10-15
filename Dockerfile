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

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js, npm, and yarn
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs
RUN npm install --global yarn

# Set working directory
WORKDIR /var/www

# Copy existing application directory
COPY --chown=www-data:www-data . /var/www

# Remove default nginx webpage
RUN rm -rf /var/www/html

# Install dependencies
RUN composer install

# Install Node.js dependencies and compile assets
RUN rm -rf node_modules
RUN yarn cache clean
RUN yarn install
RUN yarn build

# Change current user to www
USER www-data

CMD php artisan serve --host=0.0.0.0 --port=8080

EXPOSE 8080
