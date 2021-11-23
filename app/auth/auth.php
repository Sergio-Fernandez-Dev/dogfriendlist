<?php
require_once '../vendor/autoload.php';

use App\Core\DB;
use App\Auth\Mail\Email;
use App\Core\QueryBuilder;
use App\Users\UserManager;
use App\Core\Router as route;
use App\Auth\Forms\LoginForm;
use App\Auth\Forms\RegisterForm;
use Exceptions\Form\FormException;


    route::add('/login', ['GET', 'POST'],
    function () {

        session_start();

        $title = 'Login';

        switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            //Si nuestro link de activación es correcto, guardaremos el mensaje de verificación en una variable para cargarlo en la vista.
            isset($_SESSION['verification_body']) ? $verification = $_SESSION['verification_body'] : $verification = null;

            return render('auth/login.php', title: $title, verification: $verification, exception: null);

        case 'POST':
            $db = new DB();
            $qb = new QueryBuilder();
            $manager = new UserManager($db, $qb);
            $form = new LoginForm($_POST, $manager);
            //Enviamos el formulario de login.
            try {
                //Si todo es correcto nos devolverá una instancia de usuario.
                $user = $form->send();
            } catch (FormException $e) {
                $exception = $e->getMessage();

                return render('auth/login.php', title: $title, exception: $exception);
            }
            //Si el login se ha realizado correctamente, almacenamos el usuario recibido en una variable de sesión.
            $_SESSION['user'] = $user;
            
            //Si se ha seleccionado la casilla 'Recuérdame', lo registramos en una variable de sesión.
            if ($form->getRememberMe()) {
                $_SESSION['remember_me'] = true;
            }

            return redirect('');
        }
    }
);

route::add('/logout', 'GET',
    function () {

        session_start();
        session_unset();
        session_destroy();

        return redirect('');
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
            $manager = new UserManager($db, $qb);
            $form = new RegisterForm($_POST, $manager);
            $email = new Email(true);
             //enviamos el formulario de registro
            try {
               //Si todo es correcto nos devuelve un usuario con valor 'null';
                $user = $form->send();
            } catch (FormException $e) {
                $exception = $e->getMessage();

                return render('auth/register.php', title: $title, exception: $exception);
            }
            //Establecemos las propiedades de nuestro usuario en base a los datos tomados del formulario
            $user->setProperties($form->getFields());
            //Añadimos el usuario a la base de datos;
            $manager->add($user);
            //Enviamos email de validación al correo del usuario
            $email->sendVerificationEmail($user);
            //Creamos una variable de sesión con el usuario instanciado.
            session_start();
            $_SESSION['user'] = $user;

            return redirect('auth/confirm');
        }
    }
);

route::add('/confirm', ['GET', 'POST'],
    function () {

        //Comprobamos que el objeto pasado desde 'register' es accesible.
        session_start();

        isset($_SESSION['user']) ? $user = $_SESSION['user'] : $user = null;

        $email = new Email(true);
        $db = new DB();
        $qb = new QueryBuilder();
        $manager = new UserManager($db, $qb);

        $title = 'Email enviado';

        switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            //Si existe el objeto usuario mostramos la pagina de confirmación de envío del email
            if (isset($user)) {
                
                return render('auth/verification-email-sended.php', base_page: false, title: $title, user: $user);    
            //Si no, volvemos al inicio (así evitamos que se muestre 'verification-email-sended' 
            //en caso de que el  usuario introduzca la url manualmente)
            } else {
                redirect('');
            }   

        //Cuando pulsamos el botón de reenviar email
        case 'POST':
            //Si venimos desde 'register' tendremos una variable de sesión con nuestro usuario
            if (isset($_SESSION['user'])) {
                $user = $_SESSION['user'];        
            //Si venimos desde 'verification-failed' habremos recibido una peticion POST 
            //con el email introducido por el usuario. Utilizaremos ese email para instanciar
            //un nuevo usuario.
            } elseif (isset($_POST['email'])) {
                $user = $manager->findByEmail($_POST['email']);
            }
            //Enviamos un email de verificación.
            $email->sendVerificationEmail($user);

            //mostramos la pagina de confirmación de envío del email
            return render('auth/verification-email-sended.php', base_page: false, title: $title, user: $user);
        }   
    }
);

route::add("/confirm/([a-zA-Z0-9]*)", ['GET', 'POST'],
    function ($activation_key) {  

        session_start();

        $db = new DB();
        $qb = new QueryBuilder();
        $manager = new UserManager($db, $qb);

        switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            //Si el link de activación incluye el nombre de usuario
            if (isset($_GET['username'])) {
                //Lo buscamos en la base de datos
                $user = $manager->findByUsername($_GET['username']);
                //si la clave de activación de la url coincida con la clave adignada al usuario
                if  ($activation_key == $user->getActivationKey()) {

                    $title = 'Validacion exitosa';
                    //Cambiamos el rol a usuario activo, resesteamos la clave de activación 
                    // y actualizamos al usuario en la base de datos.
                    $user->setRole(1);
                    $user->setActivationKey(null);
                    $manager->save($user);
                    //Establecemos como variable de sesión el cuerpo de nuestro mensaje de verificación
                    //y hacemos una redirección a la página de login.
                    $_SESSION['verification_body'] = 'auth/verification-succeeded.php';

                    return redirect('auth/login');
                }  
            }

            $title = 'Validación errónea';

            return render('auth/verification-failed.php', base_page: false, title: $title);

        case 'POST':             
            $user = $manager->findByEmail($_POST['email']);

            $_SESSION['user'] = $user;

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