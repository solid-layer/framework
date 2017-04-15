<?php

$path = realpath('bootstrap/start.php');

if (file_exists($path) && !in_array($path, get_included_files())) {
    require_once $path;

    $kernel->modules()->run('main');
}
