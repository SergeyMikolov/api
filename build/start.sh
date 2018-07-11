#!/bin/bash

. $(dirname "$0")/help.sh

path=$(current_path)
project_dir="$path/../"

if $ENV_DEV; then
    cd "$path/dev" \
    && docker-compose -p $PROJECT_NAME_DEV up -d

    CONTAINER=$(docker ps -aqf "name=${PROJECT_NAME_DEV}_app")

    docker exec $CONTAINER chmod 777 -R storage/ \
    && docker exec $CONTAINER php artisan config:clear \
    && docker exec $CONTAINER php artisan key:generate \
    && docker exec $CONTAINER php artisan jwt:secret \
    && docker exec $CONTAINER php artisan migrate \
    && docker exec $CONTAINER composer dump-autoload
fi
