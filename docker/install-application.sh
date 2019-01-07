#!/usr/bin/env bash
_PROJECT_PATH=$(dirname $0)
. $_PROJECT_PATH/bash-scripts/functions.sh
. $_PROJECT_PATH/bash-scripts/variables.sh

_DOCKER_COMPOSE_COMMAND_BUILD="docker-compose run composer install"
if ! eval ${_DOCKER_COMPOSE_COMMAND_BUILD}; then
  echo "ERROR! Could not build the application"
  exit 1
fi

