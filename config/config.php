<?php 

define('BASE_VIEW_PATH', '../app/views/');
define('BASE_VIEW_TEMPLATE', '../app/views/base-template.php');
define('COMPONENTS_PATH', '../app/views/components/');
define('DB_CONFIG', '../config/database.php');


require_once '../app/core/Router.php';
require_once '../app/core/helpers/helpers.php';
require_once '../app/core/DBHandler.php';
require_once '../app/auth/forms/RegisterForm.php'

?>