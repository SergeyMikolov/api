#!/bin/bash

# colors for console
RED='\033[0;31m'
BLUE='\033[0;34m'
GREEN='\033[0;32m'
NC='\033[0m'

ENV_DEV=true
ENV_TEST=false

while test 2 -gt 0; do
    case "$1" in

        -h|--help)
            echo "Options:"
            printf "${BLUE}-h${NC}  ${BLUE}--help${NC}             show brief help\n"
            printf "${BLUE}-e${NC}  ${BLUE}--env${NC}              versions and configs that will be used in build. Can be ${GREEN}dev${NC}, ${GREEN}prod${NC} or ${GREEN}test${NC}\n"
            exit 0
            ;;

        -e|--env)
            shift

            if [ "$1" == "dev" ]; then
                ENV_DEV=true
            elif [ "$1" == "prod" ]; then
                ENV_DEV=false
            elif [ "$1" == "test" ]; then
                ENV_DEV=false
                ENV_TEST=true
            else
                printf "${RED}Invalid arguments -env!${NC}\n"
                printf "for show help use ${BLUE}-h${NC} or ${BLUE}--help${NC}\n"
                exit 1
            fi

            shift
            ;;

        *)
            break
            ;;
    esac
done


function current_path () {
    local script_path="`dirname \"$0\"`"
    script_path="`( cd \"$script_path\" && pwd )`"

    echo $script_path
}
