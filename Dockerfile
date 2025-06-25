FROM php:8.2-apache

# Instalar extensões necessárias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql zip

# Habilitar módulo de reescrita de URL do Apache
RUN a2enmod rewrite

# Configurar permissões
RUN chown -R www-data:www-data /var/www/ && \
    chmod -R 755 /var/www/

# Configurar PHP para exibir erros em ambiente de desenvolvimento
RUN echo "display_errors = On" >> /usr/local/etc/php/php.ini && \
    echo "error_reporting = E_ALL" >> /usr/local/etc/php/php.ini
