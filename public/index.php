<?php

require_once '../vendor/autoload.php';

use App\Core\Router as route;

route::add('/', ['GET', 'POST'],
    function () {
        
        session_start();
        $title = 'Index';

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                //Si se ha seleccionado la opción 'Recuérdame', pero no se ha guardado la id de usuario
                //en una cookie, significa que el usuario se acaba de loggear, por lo que iniciamos una cookie
                // con su id y un tiempo de expiración de 3 meses.
                if (isset($_SESSION['remember_me']) && !isset($_COOKIE['user_id'])) {
                    $user = $_SESSION['user'];
                    setcookie('user_id', $user->getId(), time() + 90 * 24 * 60 * 60);
                } 
    
            case 'POST':
                //TODO
        }
        
        return render('index.php', title: $title);
    }
);

route::add('/new-spot', ['GET', 'POST'],
function () {
    
    session_start();

    $user = $_SESSION['user'];

    $title = 'Nuevo Spot';

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
   
            return render('new-spot.php', title: $title);

        case 'POST':
            //TO-DO
    
    }
    
    
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
