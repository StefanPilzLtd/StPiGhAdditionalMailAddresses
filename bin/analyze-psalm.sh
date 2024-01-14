#!/usr/bin/env bash

if ! command -v nproc &> /dev/null
then
    THREADS="$(sysctl -n hw.logicalcpu)"
else
    THREADS="$(nproc)"
fi

printf "\n\n\n"
printf "=============================================================\n"
printf "Run static analysis tool for PHP (Psalm) with ${THREADS} threads ...\n"
printf "=============================================================\n"

# setup cache path for psalm
export XDG_CACHE_HOME=$(pwd)/var/cache

php ../../../dev-ops/analyze/vendor/bin/psalm --config=build/psalm.xml --long-progress --output-format=console --threads=${THREADS} --diff --show-info=false

# Return if psalm returns with error
if [ $? -eq 1 ]
then
  printf "\n"
  exit 1
fi

printf "\n"

