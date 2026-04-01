FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Install dependencies (optional but good)
RUN apk add --no-cache bash

# Copy project files
COPY . /var/www/html

# Set permissions
RUN chmod -R 755 /var/www/html

# Expose PHP-FPM port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
