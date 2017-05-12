#!/usr/bin/env bash

# clone slayer
git clone -b ${TRAVIS_BRANCH} --depth 1 https://github.com/phalconslayer/slayer.git ~/${SLAYER_FOLDER}

cd ~/${SLAYER_FOLDER}

rm composer.lock


#-------------------------------------------------------------------------------


# check php info
php -m

# check composer updates
composer self-update

# require framework based on version
composer require phalconslayer/framework:dev-${TRAVIS_BRANCH}
composer require techpivot/phalcon-ci-installer:~1.0

# install dependencies
composer update


#-------------------------------------------------------------------------------


# copy .env.travis as .env file
cp vendor/phalconslayer/framework/tests/.env.travis .env
mkdir config/travis
cat .env


#-------------------------------------------------------------------------------


# execute phalcon ci installer
vendor/bin/install-phalcon.sh ${PHALCON_VERSION}


#-------------------------------------------------------------------------------


# create 'slayer' database
mysql -e 'create database slayer charset=utf8mb4 collate=utf8mb4_unicode_ci;'

# db migrations
php brood db:migrate


#-------------------------------------------------------------------------------


# built-in web
php -S ${SERVE_HOST}:${SERVE_PORT} -t public/ > internal-server.log 2>&1 &
sleep 5

cd ..

#-------------------------------------------------------------------------------
