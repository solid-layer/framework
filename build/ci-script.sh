#!/usr/bin/env bash

cd ${SLAYER_FOLDER}

# call queue:worker
php brood queue:worker > queue-worker.log 2>&1 &

# +--------------------------+
# | Run PHPUnit              |
# +--------------------------+
chmod a+x ./vendor/bin/phpunit
chmod a+x ./vendor/phalconslayer/framework/phpunit.xml
./vendor/bin/phpunit -c ./vendor/phalconslayer/framework/phpunit.xml
cat queue-worker.log

# +--------------------------+
# | Run other brood commands |
# +--------------------------+
# db
php brood db:seed:factory
php brood db:status
php brood db:rollback
php brood db:create Test
php brood db:seed:create Test
php brood db:seed:run
php brood db:rollback

# app
php brood app:controller Test main
php brood app:module test
php brood app:route Test test

# clear
php brood clear:cache
php brood clear:compiled
php brood clear:logs
php brood clear:session
php brood clear:views
php brood clear:all

# mail
php brood mail:inliner

# make
php brood make:collection Test
php brood make:console Test
php brood make:model Test

cd ..
