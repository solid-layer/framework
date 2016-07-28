#!/usr/bin/env bash

if [ "$PHALCON_VERSION" != "2.0.x" ]; then

    cd ${TRAVIS_BUILD_DIR}/${PHALCON_FOLDER}/vendor/phalcon/zephir

    ZEPHIRDIR="$( cd "$( dirname . )" && pwd )"
    sed "s#%ZEPHIRDIR%#$ZEPHIRDIR#g" bin/zephir > bin/zephir-cmd
    chmod 755 bin/zephir-cmd

    mkdir -p ~/bin

    cp bin/zephir-cmd ~/bin/zephir
    rm bin/zephir-cmd

    # test zephir
    (cd ${TRAVIS_BUILD_DIR};zephir)

    # zephir load determining php version
    cd ${TRAVIS_BUILD_DIR}/${PHALCON_FOLDER}
    '[[ "$TRAVIS_PHP_VERSION" == "7.0" ]] || ( zephir fullclean && zephir generate )'
    '[[ "$TRAVIS_PHP_VERSION" != "7.0" ]] || ( zephir fullclean && zephir generate --backend=ZendEngine3 )'

fi
