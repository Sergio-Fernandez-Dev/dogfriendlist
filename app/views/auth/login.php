<?php 
//Si hemos accedido a la página de login tras una verificación del link de activación de la cuenta,
//debemos de renderizar el mensaje de verificación. En caso contrario debemos mostrar el h1 'Login'.
if (isset($verification)) {
    render($verification, base_page: false);
} else {
    echo '<h1>Login</h1>';
}

?>
<!-- A continuación renderizaremos el formulario de login -->
<?php render('auth/components/login-form.php', base_page: false, exception:  $exception) ?>