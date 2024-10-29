FROM php:8.1.29-apache-bullseye

RUN a2enmod rewrite

ENV DB_PATH=/database.db
ENV SESSION_LIFETIME=1800

WORKDIR /var/www/html

COPY init-user.php /
COPY init.sh /
COPY server/* .

RUN chown -R www-data:www-data /var/www/html
RUN chown www-data:www-data /init.sh
RUN chmod +x /init.sh

ENTRYPOINT [ "/bin/bash" ]
CMD [ "/init.sh" ]

EXPOSE 80
