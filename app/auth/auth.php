<?php
require_once '../vendor/autoload.php';

use App\Users\User;
use App\Core\DBHandler;
use App\Core\QueryBuilder;
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
        $dbh = new DBHandler();
        $qb = new QueryBuilder();
        $form = new RegisterForm($_POST, $qb);
        try {
            $query = $form->send($dbh);
        } catch (FormException $e) {
            $exception = $e->getMessage();

            return render('auth/register-form.php', true, ['title' => '- Registro', 'exception' => $exception]);
        }
        $user = new User();

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