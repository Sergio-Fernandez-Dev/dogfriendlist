<?php
require_once '../vendor/autoload.php';

use App\Core\DB;
use App\Auth\Mail\Email;
use App\Core\QueryBuilder;
use App\Users\UserManager;
use App\Core\Router as route;
use App\Auth\Forms\RegisterForm;
use Exceptions\Form\FormException;


    route::add('/login', ['GET', 'POST'],
    function () {

        $title = 'Login';

        switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':
            return render('auth/login-form.php', title: $title);

        case 'POST':
            //Si role = 0 manda a reenviar correo de confirmación
        }

    }
);


route::add('/register', ['GET', 'POST'],
    function () {

        $title = 'Registro';

        switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':
            return render('auth/register-form.php', title: $title);

        case 'POST':
            $db = new DB();
            $qb = new QueryBuilder();
            $u_manager = new UserManager($db, $qb);
            $form = new RegisterForm($_POST, $u_manager);
            $email = new Email(true);

            try {

                $user = $form->send($db);

            } catch (FormException $e) {

                $exception = $e->getMessage();

                return render('auth/register-form.php', title: $title, exception: $exception);
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
        $user = $_SESSION['user'];

        $email = new Email(true);
        $title = 'Email enviado';

        switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':

            return render('auth/validation-email-sended.php', title: $title, user: $user);

        case 'POST':

            $email->sendVerificationEmail($user);
            echo $user->getEmail();

            return render('auth/validation-email-sended.php', title: $title, user: $user);
        }

    }
);

    route::add("/confirm/([a-zA-Z0-9]*)", 'GET',
    function ($activation_key) {

        session_start();
        $user = $_SESSION['user'];


        switch ($_SERVER['REQUEST_METHOD']) {

            case 'GET':

            if  ($activation_key == $user->getActivationKey()) {

                $title = 'Validation Succeeded';

                return render('auth/validation-succeeded.php', title: $title);

            } else {

                $title = 'Validation Failed';
                echo 'get';

                //return render('auth/validation-faileded.php', title: $title, user: $user);
            }
                
    
            case 'POST':
                echo 'post';
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