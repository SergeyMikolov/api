#!/bin/bash

. $(dirname "$0")/help.sh


path=$(current_path)
project_dir="$path/../"

if $ENV_DEV; then
    cd "$path/dev" \
    && docker-compose -p studio_dev up -d

    CONTAINER=$(docker ps -aqf "name=studio_dev_app")

    docker exec $CONTAINER chmod 777 -R storage/ \
    && docker exec $CONTAINER php artisan config:clear \
    && docker exec $CONTAINER php artisan key:generate \
    && docker exec $CONTAINER php artisan migrate

elif $ENV_TEST; then
    cd "$path/tests" \
    && docker-compose -p studio_tests up -d

else
    cd "$path/prod" \
    && docker-compose -p studio up -d

    CONTAINER=$(docker ps -aqf "name=studio_app")

    docker exec $CONTAINER chmod 777 -R storage/ \
    && docker exec $CONTAINER php artisan config:clear \
    && docker exec $CONTAINER php artisan key:generate \

    docker run --rm --interactive --tty \
        --volume "$project_dir":/app \
        --volume ~/.ssh/:/root/.ssh \
        composer install
fi
