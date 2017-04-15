<?php

$path = realpath('bootstrap/start.php');

if (file_exists($path)) {
    require_once $path;

    $kernel->modules()->run('main');
}
