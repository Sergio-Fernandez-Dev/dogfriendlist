<?php

require_once '../vendor/autoload.php';

use App\Core\Router as route;

route::add('/', 'GET',
    function () {
        return render('index.php', true, ['title' => 'Index', 'user' => 'Sergio']);
    }
);

route::add('/auth/([a-zA-Z0-9]*)', ['GET', 'POST'],
    function ($action) {
        return require_once '../app/auth/auth.php';
    }
);

route::add('/test', 'GET',
    function () {
        require_once '../app/test.php';
    }
);

route::run('');
