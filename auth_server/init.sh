#!/bin/bash

cleanup() {
    echo "Exiting gracefully..."
    exit 0
}

trap cleanup SIGINT SIGTERM

php /init-user.php $ADMIN_USERNAME $ADMIN_PASSWORD
chown -R www-data:www-data $DB_PATH

apache2-foreground