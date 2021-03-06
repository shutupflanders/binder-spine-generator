FROM php:8.1-cli as base
LABEL maintainer="Martin Brooksbank <martin@bosslabs.co.uk>"

# Install necessary OS packages
RUN apt-get update && apt-get upgrade -y
RUN apt-get install -y \
        git \
        libzip-dev \
        zlib1g-dev \
        libxml2-dev

# Install necessary PHP packages
RUN docker-php-ext-install \
        zip \
        xml

# Copy the application files
COPY . /app

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Create io directories
RUN mkdir /input
RUN mkdir /output

WORKDIR /app

# Up the memory limit
RUN sed -E -i -e 's/memory_limit = 128M/memory_limit = 1024M/' /usr/local/etc/php/php.ini-production
RUN mv /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

# Install Composer packages
RUN composer install -q -n

# Run the get-results command and accept args from stdin
ENTRYPOINT ["php", "/app/run.php"]