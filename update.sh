#!/bin/bash

APP_ENV=dev
FORCE=0

while [ $# -gt 0 ]; do
  case "$1" in
    --env=*)
      APP_ENV="${1#*=}"
      ;;
    -f)
      FORCE=1
      ;;
    --help)
      echo "***************************"
      echo "Usage:"
      echo " ./update.sh [--env=dev|prod|staging|test] [-f]"
      echo ""
      echo "Options:"
      echo "  --env     app enviroment (default: \"dev\")"
      echo "  -f        force update"
      echo "***************************"
      ;;
    *)
      echo "***************************"
      echo "* Error: Invalid argument ${1}"
      echo "***************************"
      exit 1
  esac
  shift
done

PHP_VERSION=$(php -v | grep "PHP 5" | sed 's/.*PHP \([^-]*\).*/\1/' | cut -c 1-3)
echo "Installed PHP version: '$PHP_VERSION'"

export APP_ENV=${APP_ENV}

git fetch origin

# check git updates
GIT_CHANGED=false
CURENT_BRANCH=`git branch 2> /dev/null | sed -e '/^[^*]/d' -e 's/* \(.*\)/\1/'`
if [ -n "`git diff HEAD origin/${CURENT_BRANCH}`" ]; then GIT_CHANGED=true; fi;

if [ ${FORCE} == 0 ]; then
    if [ ${GIT_CHANGED} == false ]; then
        echo 'Already up-to-date'
        exit
    fi
fi;

# run main logic
if [ ${APP_ENV} == 'dev' ];
then
    git pull origin ${CURENT_BRANCH}
else
    git reset --hard origin/${CURENT_BRANCH}
fi;

COMPOSER_OPT=''
if [ ${APP_ENV} == 'prod' ];
then
    COMPOSER_OPT="-o --no-dev"
fi;

composer install ${COMPOSER_OPT}

# console commands
php artisan migrate --force
php artisan asgard:publish:theme

exit