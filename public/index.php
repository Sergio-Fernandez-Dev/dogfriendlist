<?php 

require_once '../app/core/Router.php';
require_once '../app/auth/AuthController.php';

use App\Core\Router;
use App\Auth\AuthController;

Router::add('/', function(){
    echo '<h1>Hello World</h1>';
},'GET');

Router::add('/auth/(.*)', function($action)
{
    $controller = new AuthController();
    $controller->index($action);
},'get');

Router::run('/');

?>