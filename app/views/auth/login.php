<?php 
//Si hemos accedido a la página de login tras una verificación del link de activación de la cuenta,
//debemos de renderizar el mensaje de verificación. En caso contrario debemos mostrar el h2 'Login'.
if (isset($verification)) {
    render($verification, base_page: false);
} else {
    $login_title = '<h2 class="h2 h2--form">Login</h2>';
}

?>
<!-- A continuación renderizaremos el formulario de login -->
<div class="box">
<?php render('auth/components/login-form.php', base_page: false, exception:  $exception, login_title: $login_title) ?>
</div>