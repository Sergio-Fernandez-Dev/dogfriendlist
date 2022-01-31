<?php

require_once '../vendor/autoload.php';

use App\Core\DB;
use App\Core\QueryBuilder;
use App\Models\Spots\SpotHandler;
use App\Core\Router as route;
use App\Forms\SpotForm;
use App\Models\Users\UserHandler;
use Exceptions\Form\FormException;
use Exceptions\Db\UserNotFoundException;


route::add('/', ['GET', 'POST'], 
    function () {
        session_start();

        $title = 'Index';

        //Establecemos las rutas que cargarán nuestros archivos javascript.
        $scripts = [
            SCRIPTS_PATH . 'main-map.php',
            SCRIPTS_PATH . 'fav-map.php',
            SCRIPTS_PATH . 'google-api.php',
            SCRIPTS_PATH . 'buttons.php'
        ];

        if (isset($_SESSION['user']) && !is_array($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $user_data = formatUserData($user);
            $_SESSION['user'] = $user_data;
        }

        //Si existe una cookie con la id de usuario , 
        // utilizamos la cookie para crear nuestra sesión de usuario, evitando la necesidad
        // de volver a identificarse.
        if (isset($_COOKIE['user_id'])) {
            $db = new DB();
            $qb = new QueryBuilder();
            $handler = new UserHandler($db, $qb);

            try {
                $user = $handler->find($_COOKIE['user_id']);

                $user_data = formatUserData($user);
                $_SESSION['user'] = $user_data;
                $id = $_COOKIE['user_id'];
                        
                //Si la cookie existe, pero la variable 'remeber_me' no está activa, significa
                //que el navegador ha sido cerrado.
                if (!isset($_SESSION['remember_me'])) {
                    //Reseteamos el tiempo de expiración de la cookie.
                     setcookie('user_id', $id, time() + 90 * 24 * 60 * 60, '/');
                     $_SESSION['remember_me'] = true;
                }
            } catch (UserNotFoundException $e) {
                unset($_COOKIE['user_id']);
            }       
        }
        //Establecemos la función a la que llamaremos para crear nuestro mapa;
        $callback = 'initMap';
        return render('index.php', title: $title, scripts: $scripts, callback: $callback);           
    }
);

route::add('/new-spot', ['GET', 'POST'],
    function () {

        session_start();
        authRequired('auth/login');

        $title = 'Nuevo Spot';

        $scripts = [
            SCRIPTS_PATH . 'main-map.php',
            SCRIPTS_PATH . 'new-spot-map.php',
            SCRIPTS_PATH . 'google-api.php',
            SCRIPTS_PATH . 'buttons.php'
        ];
    
        $user = $_SESSION['user'];
    
    
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $callback = 'newMap';
                
                return render('new-spot.php', title: $title, scripts: $scripts, callback: $callback);
            
            case 'POST':
                $db = new DB();
                $qb = new QueryBuilder();
                $handler = new SpotHandler($db, $qb);
                $form = new SpotForm($_POST, $handler);

                // enviamos el formulario 
                try {
                    $spot = $form->send();            

                } catch (FormException $e) {
                    $exception = $e->getMessage();
                    echo $exception;
                    //return render('new-spot.php', title: $title, exception: $exception, scripts: $scripts);
                }   
                
                $spot_data = $form->getFields();
                $spot = $handler->make($spot_data);
                $handler->add($spot);

                redirect('');

        }
    }
);

route::add('/favourites', ['GET', 'POST'],
    function () {

        session_start();
        authRequired('auth/login');

        $title = 'Favoritos';
        
        $scripts = [
            SCRIPTS_PATH . 'main-map.php',
            SCRIPTS_PATH . 'fav-map.php',
            SCRIPTS_PATH . 'google-api.php',
            SCRIPTS_PATH . 'buttons.php'
        ];
    
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
            
                 //Establecemos la función a la que llamaremos para crear nuestro mapa;
                 $callback = 'chargeFavSpots';

                return render('favourites.php', title: $title, scripts: $scripts, callback: $callback);
            case 'POST':
        }      

        //Establecemos la función a la que llamaremos para crear nuestro mapa;
        $callback = 'chargeFavSpots';

        return render('favourites.php', title: $title, scripts: $scripts, callback: $callback);
    }
);

route::add('/auth/([a-zA-Z0-9/]*)', ['GET', 'POST'],
    function () {
        
        require_once '../app/Auth/auth.php';
    }
);

route::add('/geolocation/([a-zA-Z0-9-_/]*)', ['GET', 'POST'],
    function () {

        require_once '../app/Geolocation/geolocation.php';
    }
);

route::methodNotAllowed(
    function() {

        render('errors/405.php', false);
    }
);

route::pathNotFound(
    function() {

        render('errors/404.php', false);
    }
);

route::add('/test', ['GET', 'POST'],
    function () {

        require_once '../app/test.php';
    }
);

route::run('');
