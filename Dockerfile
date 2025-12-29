FROM php:8.2-apache

# Instalujemy rozszerzenia dla bazy danych (jeśli używasz Postgres, dodaj libpq-dev)
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql

# Kopiujemy Twoje pliki do folderu serwera
COPY . /var/www/html/

# Ustawiamy uprawnienia
RUN chown -R www-data:www-data /var/www/html

# Informujemy, że serwer pracuje na porcie 80
EXPOSE 80