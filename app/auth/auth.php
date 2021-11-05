<?php
require_once '../vendor/autoload.php';

use App\Core\DB;
use App\Core\QueryBuilder;
use App\Users\UserManager;
use App\Core\Router as route;
use App\Auth\Forms\RegisterForm;
use Exceptions\Form\FormException;

route::add('/login',
    function () {
        return render('auth/login-form.php', true, ['title' => 'Dogfriendlist - Login']);
    },
    'GET'
);

route::add('/register',
    function () {
        return render('auth/register-form.php', true, ['title' => 'Registro']);
    },
    'GET'
);

route::add('/register',
    function () {
        $db = new DB();
        $qb = new QueryBuilder();
        $u_manager = new UserManager($db, $qb);
        $form = new RegisterForm($_POST, $u_manager);

        try {
            $user = $form->send($db);
        } catch (FormException $e) {
            $exception = $e->getMessage();

            return render('auth/register-form.php', true, ['title' => '- Registro', 'exception' => $exception]);
        }

        $user->setClassParams($form->getFields());
        $u_manager->add($user);

    },
    'POST'
);

route::add('/all',
    function () {
        return print_r(route::getAll());
    },
    'GET'
);

route::run('/auth');

?>