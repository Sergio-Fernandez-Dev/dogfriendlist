<?php

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->safeLoad();

$mail_config = [
    'host'     => $_ENV['MAIL_HOST'],
    'username' => $_ENV['MAIL_USERNAME'],
    'password' => $_ENV['MAIL_PASSWORD'],
    'address'  => $_ENV['MAIL_ADDRESS'],
    'name'     => $_ENV['MAIL_NAME'],
];

return $mail_config;

?>