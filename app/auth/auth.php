<?php 

use App\Core\Interfaces\QueryBuilderInterface;
use App\Core\QueryBuilder;
use App\Core\Router as route;

route::add('/login', function()
{
   return render('auth/login-form.php', true);
},
'GET');

route::add('/login-form',function()
{
    echo '<form action="login-form" method="post"><input type="text" name="test" /><input type="submit" value="send" /></form>';
},
'POST');

route::add('/register', function(){

   return render('auth/register-form.php', true);
},
'GET');

route::add('/register', function()
{
   $qb = new QueryBuilder();
   $form = new RegisterForm($_POST, $qb);
   $query = $form->send();
},
'POST');

route::run('/auth');

?>