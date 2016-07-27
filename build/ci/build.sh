#!/usr/bin/env bash

# handle slayer installation
if [ ! -f "${TRAVIS_BUILD_DIR}/${SLAYER_FOLDER}/composer.json" ]; then

    composer create-project phalconslayer/slayer:${SLAYER_VERSION} ${TRAVIS_BUILD_DIR}/${SLAYER_FOLDER}

    cd ${TRAVIS_BUILD_DIR}/${SLAYER_FOLDER}

    composer update

    # run the composer update
    composer self-update
    php -m

    cd ..

fi

cd ${TRAVIS_BUILD_DIR}/${SLAYER_FOLDER}

# copy .env.travis as .env file
cp vendor/phalconslayer/framework/tests/.env.travis .env
cat .env

# create 'slayer' database
mysql -e 'create database slayer charset=utf8mb4 collate=utf8mb4_unicode_ci;'

# db migrations
php brood db:migrate

# built-in web
php -S ${SERVE_HOST}:${SERVE_PORT} -t public/ > built-in.log 2>&1 &
sleep 5

cd ..
