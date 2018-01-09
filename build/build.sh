#!/bin/bash

. $(dirname "$0")/help.sh


path=$(current_path)
project_dir="$path/../"

if [ -f "$project_dir/../.env" ] ;
	then
		rm "$project_dir/../.env"
fi


if $ENV_DEV; then
    cp "$path/.dev.env" "$project_dir/.env"

    printf "PROJECT_DIR=$project_dir" > "$path/dev/.env"

    cd "$path/dev" && docker-compose -p studio_dev build

   # docker run --rm --interactive --tty \
       # --volume "$project_dir":/app \
       # --volume ~/.ssh/:/root/.ssh \
        #composer install

elif $ENV_TEST; then
    cp "$path/.tests.env" "$project_dir/.env"

    printf "PROJECT_DIR=$project_dir" > "$path/tests/.env"

    cd "$path/tests" && docker-compose -p pstudio_tests build

else
    cp "$path/.prod.env" "$project_dir/.env"

    printf "PROJECT_DIR=$project_dir" > "$path/prod/.env"

    cd "$path/prod" && docker-compose -p pstudio_build

    docker run --rm --interactive --tty \
        --volume "$project_dir":/app \
        --volume ~/.ssh/:/root/.ssh \
        composer install
fi

