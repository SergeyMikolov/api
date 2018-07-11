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

    cd "$path/dev" && docker-compose -p $PROJECT_NAME_DEV build
fi

