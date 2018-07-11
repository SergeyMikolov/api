#!/bin/bash

. $(dirname "$0")/help.sh

path=$(current_path)

cd "$path/dev" && \
	docker-compose stop

cd "$path/prod" && \
	docker-compose stop