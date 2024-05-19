# Use the official PHP image as a base image
FROM php:7.4-apache

# Set the ServerName directive
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Install Node.js and npm
RUN apt-get update && \
    apt-get install -y curl && \
    curl -sL https://deb.nodesource.com/setup_14.x | bash -

# Install TailwindCSS dependencies
WORKDIR /var/www/html

# Enable mod_rewrite
RUN a2enmod rewrite

# Install necessary PHP extensions
RUN docker-php-ext-install mysqli

# Copy project files to the working directory
COPY . .

# Set working directory
WORKDIR /var/www/html
