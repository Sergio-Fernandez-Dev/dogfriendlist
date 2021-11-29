<?php

require_once '../vendor/autoload.php';

use App\Core\DB;
use App\Core\QueryBuilder;
use App\Models\Spots\SpotHandler;
use App\Core\Router as route;
use App\Forms\SpotForm;
use App\Models\Users\UserHandler;
use Exceptions\Form\FormException;

route::add('/', ['GET', 'POST'],
    function () {
        session_start();

        $title = 'Index';

        //Establecemos las rutas que cargarán nuestros archivos javascript.
        $scripts = [
            SCRIPTS_PATH . 'main-map.php',
            SCRIPTS_PATH . 'google-api.php',
        ];

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':

                //Si se ha seleccionado la opción 'Recuérdame', pero no se ha guardado la id de usuario
                //en una cookie, significa que el usuario se acaba de loggear, por lo que iniciamos una cookie
                // con su id y un tiempo de expiración de 3 meses.
                if (isset($_SESSION['remember_me']) && !isset($_COOKIE['user_id'])) {
                    $user = $_SESSION['user'];
                    setcookie('user_id', $user->getId(), time() + 90 * 24 * 60 * 60);
                } 

                //Si existe una cookie con la id de usuario pero no hay una sesión activa, 
                // utilizamos la cookie para crear nuestra sesión de usuario, evitando la necesidad
                // de volver a identificarse.
                if (isset($_COOKIE['user_id']) && !isset($_SESSION['user'])) {
                    $db = new DB();
                    $qb = new QueryBuilder();
                    $handler = new UserHandler($db, $qb);

                    $user = $handler->find($_COOKIE['user_id']);
                    $_SESSION['user'] = $user;
                }
                //Establecemos la función a la que llamaremos para crear nuestro mapa;
                $callback = 'initMap';
    
            case 'POST':
                //TODO
                
        }
        
        return render('index.php', title: $title, scripts: $scripts, callback: $callback);
    }
);

route::add('/new-spot', ['GET', 'POST'],
    function () {
        
        session_start();
        authRequired();
    
        $user = $_SESSION['user'];
    
        $title = 'Nuevo Spot';
    
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
            
                return render('new-spot.php', title: $title);
            
            case 'POST':
                $db = new DB();
                $qb = new QueryBuilder();
                $handler = new SpotHandler($db, $qb);
                $form = new SpotForm($_POST, $handler);
            
                 //enviamos el formulario 
                try {
                   //Si todo es correcto nos devuelve un spot con valor 'null';
                    $user = $form->send();
                } catch (FormException $e) {
                    $exception = $e->getMessage();
                
                    return render('new-spot.php', title: $title, exception: $exception);
                }
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
