#!/usr/bin/env bash

# install  phalcon/cphalcon
git clone -q --depth=1 https://github.com/phalcon/cphalcon.git -b ${PHALCON_VERSION}
(cd cphalcon/ext; export CFLAGS="-g3 -O1 -fno-delete-null-pointer-checks -Wall"; phpize && ./configure --enable-phalcon && make -j4 && make install && phpenv config-add ../unit-tests/ci/phalcon.ini)
php -r 'echo \Phalcon\Version::get()."\n";'

# install beanstalk
(sudo apt-get install -y beanstalkd;sudo service beanstalkd start;beanstalkd -h)
sudo bash -c 'echo "START=yes" >> /etc/default/beanstalkd'
sudo service beanstalkd restart

# handle slayer installation
if [ ! -f "${SLAYER_FOLDER}/composer.json" ]; then

    composer create-project phalconslayer/slayer:${SLAYER_VERSION} ${SLAYER_FOLDER}

    cd ${SLAYER_FOLDER}

    composer update

    # run the composer update
    composer self-update
    php -m

    cd ..

fi

cd ${SLAYER_FOLDER}

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
