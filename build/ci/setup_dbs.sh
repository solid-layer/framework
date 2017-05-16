#!/usr/bin/env bash

source ${TRAVIS_BUILD_DIR}/tests/_ci/install_common.sh

(mysql -uroot -e 'create database slayer charset=utf8mb4 collate=utf8mb4_unicode_ci;' && mysql -uroot slayer < "${TRAVIS_BUILD_DIR}/tests/_data/schemas/mysql/mysql.dump.sql") &
(psql -c 'create database slayer;' -U postgres && psql -U postgres slayer -q -f "${TRAVIS_BUILD_DIR}/tests/_data/schemas/postgresql/phalcon_test.sql") &
sqlite3 ${SLAYER_FOLDER}/database/slayer.sqlite < "${TRAVIS_BUILD_DIR}/tests/_data/schemas/sqlite/phalcon_test.sql"

wait
