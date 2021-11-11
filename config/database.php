<?php

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->safeLoad();

$db_config = [
    'driver'  => $_ENV['DB_DRIVER'],
    'host'    => $_ENV['DB_HOST'],
    'user'    => $_ENV['DB_USER'],
    'pass'    => $_ENV['DB_PASS'],
    'name'    => $_ENV['DB_NAME'],
    'charset' => $_ENV['DB_CHARSET'],
];

return $db_config;

?>