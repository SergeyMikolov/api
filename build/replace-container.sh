#!/usr/bin/env bash

SCRIPT_PATH="`dirname \"$0\"`"              # relative
SCRIPT_PATH="`( cd \"$SCRIPT_PATH\" && pwd )`"  # absolutized and normalized

if [ -z "$SCRIPT_PATH" ]; then
  exit 1  # fail
fi
cd "$SCRIPT_PATH/prod"

old_container=$(docker-compose -p puzzland ps app | awk '{print $1}' | tail -n +3)

docker-compose -p puzzland build app
docker-compose -p puzzland up --scale app=2 -d --no-recreate --no-deps app
docker-compose -p puzzland exec web nginx -s reload
#docker exec puzzland_web_1 nginx -s reload

all_container=$(docker-compose -p puzzland ps app | awk '{print $1}' | tail -n +3)
new_container=$(echo ${old_container[*]} ${all_container[*]} | tr ' ' '\n' | sort | uniq -u)


for container in $old_container; do
    docker kill $container
    docker-compose -p puzzland exec web nginx -s reload
#    docker exec puzzland_web_1 nginx -s reload
done
docker rm $(docker ps -aqf status=exited)

docker rename $new_container $old_container