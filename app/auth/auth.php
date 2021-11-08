<?php
require_once '../vendor/autoload.php';

use App\Core\DB;
use App\Core\QueryBuilder;
use App\Users\UserManager;
use App\Core\Router as route;
use App\Auth\Forms\RegisterForm;
use Exceptions\Form\FormException;

route::add('/login', 'GET',
    function () {
        return render('auth/login-form.php', true, ['title' => 'Dogfriendlist - Login']);
    }
);

/* route::add('/register', 'GET',
function () {
return render('auth/register-form.php', true, ['title' => 'Registro']);
}
); */

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

            try {
                $user = $form->send($db);
            } catch (FormException $e) {
                $exception = $e->getMessage();

                return render('auth/register-form.php', true, ['title' => '- Registro', 'exception' => $exception]);
            }

            $user->setProperties($form->getFields());
            $stmt = $u_manager->add($user);

            //print_r($stmt);
        }

    }
);

route::add('/all', 'GET',
    function () {
        return print_r(route::getAll());
    },
    'GET'
);

route::run('/auth');

?>