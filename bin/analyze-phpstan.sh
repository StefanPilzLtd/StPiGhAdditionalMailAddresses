#!/usr/bin/env bash

printf "\n\n\n"
printf "=============================================================\n"
printf "Run static analysis tool for PHP (PHPStan) ...\n"
printf "=============================================================\n"

php "`dirname \"$0\"`"/phpstan-config-generator.php
composer dump-autoload
php ../../../dev-ops/analyze/vendor/bin/phpstan analyze --configuration phpstan.neon --autoload-file=../../../vendor/autoload.php .

# Return if phpstan returns with error
if [ $? -eq 1 ]
then
  exit 1
fi
