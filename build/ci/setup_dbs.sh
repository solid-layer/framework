#!/usr/bin/env bash

source ${TRAVIS_BUILD_DIR}/tests/_ci/install_common.sh

(mysql -uroot -e 'create database slayer charset=utf8mb4 collate=utf8mb4_unicode_ci;') &
(psql -c 'create database slayer;' -U postgres)
# &sqlite3 ${SLAYER_FOLDER}/database/slayer.sqlite

wait
