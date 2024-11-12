# Sử dụng PHP 8-FPM
FROM php:8-fpm

# Thiết lập thư mục làm việc
WORKDIR /var/www

# Sao chép composer.lock và composer.json
COPY composer.lock composer.json ./

# Cài đặt script để cài đặt các PHP extensions
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && sync

# Cài đặt các PHP extensions cần thiết
RUN install-php-extensions mbstring pdo_mysql zip exif pcntl gd

# Cài đặt các package cần thiết
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    net-tools && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Cài đặt Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Tạo user và group cho ứng dụng Laravel
RUN groupadd -g 1000 www && \
    useradd -u 1000 -ms /bin/bash -g www www

# Sao chép toàn bộ mã nguồn vào container
COPY . .

# Sao chép file cấu hình PHP-FPM
COPY www.conf /usr/local/etc/php-fpm.d/www.conf

# Thiết lập quyền cho thư mục
RUN chown -R www:www /var/www

# Cài đặt các package PHP từ Composer
RUN composer install --optimize-autoloader --no-dev

# Tạo file .env nếu chưa có
RUN cp .env.example .env

# Tạo application key cho Laravel
RUN php artisan key:generate

# Clear cache, config, và optimize
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Đổi user hiện tại sang 'www'
USER www

# Expose port 9000
EXPOSE 9000

# Khởi động PHP-FPM
CMD ["php-fpm"]
