<?php

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->safeLoad();

define('URL_ROOT', $_ENV['URL_ROOT']);
define('URL_PREFIX', $_ENV['URL_PREFIX']);

define('BASE_VIEW_PATH', '../app/views/');
define('BASE_VIEW_TEMPLATE', '../app/views/base-template.php');
define('COMPONENTS_PATH', '../app/views/components/');

define('DB_CONFIG', '../config/database.php');

define('MAIL_CONFIG', '../config/mail.php');

define('API_KEY', $_ENV['API_KEY']);

define('SCRIPTS_PATH', '../app/views/components/scripts/');

?>