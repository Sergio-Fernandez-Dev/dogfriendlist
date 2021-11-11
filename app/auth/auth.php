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

        switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':
            return render('auth/login-form.php', true, ['title' => 'Dogfriendlist - Login']);

        case 'POST':
            //Si role = 0 manda a reenviar correo de confirmación
        }

    }
);

route::add('/register', ['GET', 'POST'],
    function () {

        switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':
            return render('auth/register-form.php', true, ['title' => 'Registro']);

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

                return render('auth/register-form.php', true, ['title' => '- Registro', 'exception' => $exception]);
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
        $msg = "";

        switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':

            return render('auth/validation-email-sended.php', true, ['title' => 'Validación', 'user' => $user, 'msg' => $msg]);

        case 'POST':

            $email->sendVerificationEmail($user);
            $msg = 'El correo ha sido enviado de nuevo';

        }

    }
);

route::add('/all', 'GET',
    function () {
        return print_r(route::getAll());
    }
);

route::run('/auth');

?>