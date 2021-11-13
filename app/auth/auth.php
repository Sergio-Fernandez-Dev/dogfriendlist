<?php
require_once '../vendor/autoload.php';

use App\Core\DB;
use App\Auth\Mail\Email;
use App\Core\QueryBuilder;
use App\Users\UserManager;
use App\Core\Router as route;
use App\Auth\Forms\RegisterForm;
use App\Auth\Forms\LoginForm;
use Exceptions\Form\FormException;


    route::add('/login', ['GET', 'POST'],
    function () {

        $title = 'Login';

        switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':
            return render('auth/login.php', title: $title);

        case 'POST':
            $db = new DB();
            $qb = new QueryBuilder();
            $u_manager = new UserManager($db, $qb);
            $form = new LoginForm($_POST, $u_manager);

            try {

                $user = $form->send();

            } catch (FormException $e) {

                $exception = $e->getMessage();

                return render('auth/login.php', title: $title, exception: $exception);
            }

            echo 'todo bien';
            
        }

    }
);


route::add('/register', ['GET', 'POST'],
    function () {

        $title = 'Registro';

        switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':
            return render('auth/register.php', title: $title, exception: null);

        case 'POST':
            $db = new DB();
            $qb = new QueryBuilder();
            $u_manager = new UserManager($db, $qb);
            $form = new RegisterForm($_POST, $u_manager);
            $email = new Email(true);

            try {

                $user = $form->send();

            } catch (FormException $e) {

                $exception = $e->getMessage();

                return render('auth/register.php', title: $title, exception: $exception);
            }

            $user->setProperties($form->getFields());
            $u_manager->add($user);

            $email->sendVerificationEmail($user);

            session_start();
            $_SESSION['user'] = $user;

            return redirect('auth/confirm');
        }

    }
);

route::add('/confirm', ['GET', 'POST'],
    function () {

        session_start();
        isset($_SESSION['user']) ? $user = $_SESSION['user'] : $user = null;

        $email = new Email(true);
        $title = 'Email enviado';

        switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':

            if (isset($user)) {
                
                return render('auth/validation-email-sended.php', base_page: false, title: $title, user: $user);    

            } else {

                redirect('');

            }

        case 'POST':
        
            $user = $_SESSION['user'];

            $email->sendVerificationEmail($user);

            return render('auth/validation-email-sended.php', base_page: false, title: $title, user: $user);
        }

    }
);

route::add("/confirm/([a-zA-Z0-9]*)", ['GET', 'POST'],
    function ($activation_key) {

        $db = new DB();
        $qb = new QueryBuilder();
        $u_manager = new UserManager($db, $qb);

        switch ($_SERVER['REQUEST_METHOD']) {

            case 'GET':

                if (isset($_GET['user'])) {

                    $user = $u_manager->findByNickname($_GET['user']);

                 if  ($activation_key == $user->getActivationKey()) {

                        $title = 'Validacion exitosa';
                
                        $user->setRole(1);
                        $user->setActivationKey(null);
                        $u_manager->save($user);
                
                        return render('auth/validation-succeeded.php', base_page: false, title: $title);
                    }  
                }

                $title = 'Validación errónea';

                return render('auth/validation-failed.php', base_page: false, title: $title);

            case 'POST':
                session_start();
        
                $user = $_SESSION['user'];
                
                $user = $u_manager->findByEmail($_POST['email']);

                redirect('auth/confirm');
        
        }

            
                  
    }
);

route::add('/all', 'GET',
    function () {
        return print_r(route::getAll());
    }
);

route::methodNotAllowed(
    function() {
        echo 'no existe el metodo';
    }
);

route::pathNotFound(
    function() {
        echo 'path no encontrado';
    }
);

route::run('/auth');

?>