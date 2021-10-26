<?php

require_once '../vendor/autoload.php';

use App\Core\Router as route;

route::add('/',
    function () {
        return render('index.php', true, ['title' => 'Index', 'user' => 'Sergio']);
    },
    'GET'
);

route::add('/auth/([a-zA-Z0-9]*)',
    function ($action) {
        return require_once '../app/auth/auth.php';
    },
    ['GET', 'POST']
);

route::add('/test',
    function () {
        require_once '../app/test.php';
    },
    'GET'
);

route::run('');
