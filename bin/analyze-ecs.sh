#!/usr/bin/env bash

printf "\n\n\n"
printf "=============================================================\n"
printf "Run static analysis tool for PHP (ecs)\n"
printf "by shopware platform easy coding standard ...\n"
printf "=============================================================\n"

php ../../../dev-ops/analyze/vendor/bin/ecs check --fix --config ../../../vendor/shopware/platform/easy-coding-standard.php ./src

# Return if ecs returns with error
if [ $? -eq 1 ]
then
  exit 1
fi

printf "\n\n\n"
printf "=============================================================\n"
printf "Run static analysis tool for PHP (ecs) ...\n"
printf "by stpi easy coding standard ...\n"
printf "=============================================================\n"

php ../../../dev-ops/analyze/vendor/bin/ecs check --fix --config=build/easy-coding-standard.php

# Return if ecs returns with error
if [ $? -eq 1 ]
then
  exit 1
fi
