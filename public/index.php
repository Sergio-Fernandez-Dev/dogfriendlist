<?php

require_once '../vendor/autoload.php';

use App\Core\Router as route;

route::add('/', 'GET',
    function () {
        session_start();

        $title = 'Index';

        print_r($_SESSION['user']);

        return render('index.php', title: $title);
    }
);

route::add('/auth/([a-zA-Z0-9/]*)', ['GET', 'POST'],
    function ($action) {
       require_once '../app/Auth/auth.php';
    }
);


route::add('/test', 'GET',
    function () {

        require_once '../app/test.php';
    }
);

route::run('');
