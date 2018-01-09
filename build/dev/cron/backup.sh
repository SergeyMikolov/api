#!/usr/bin/env bash

date=$(date '+%Y-%m-%d.%H%M%S')

DB_CONTAINER=$(docker ps -aqf "name=puzzland_database")

cd /remote_backup/puzzland \
    && docker exec -i $DB_CONTAINER pg_dump -U puzzuser puzzland > dump.sql \
    && tar -jcvf "puzzland.dump.$date.sql.tar.bz2" dump.sql \
    && rm dump.sql