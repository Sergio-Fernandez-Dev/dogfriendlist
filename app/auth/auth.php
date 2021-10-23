<?php 


use App\Core\QueryBuilder;
use App\Core\DBHandler;
use App\Core\Router as route;


route::add('/login', function()
{
   return render('auth/login-form.php', true, ['title' => 'Dogfriendlist - Login']);
},
'GET');

route::add('/login-form',function()
{
   echo '<form action="login-form" method="post"><input type="text" name="test" /><input type="submit" value="send" /></form>';
},
'POST');

route::add('/register', function(){

   return render('auth/register-form.php', true, ['title' => 'Dogfriendlist - Registro']);
},
'GET');

route::add('/register', function()
{
   $dbh = new DBHandler();
   $qb = new QueryBuilder();
   $form = new RegisterForm($_POST, $qb);
   $query = $form->send($dbh);
},
'POST');

route::add('/all', function(){

   return print_r(route::getAll());
},
'GET');

route::run('/auth');

?>