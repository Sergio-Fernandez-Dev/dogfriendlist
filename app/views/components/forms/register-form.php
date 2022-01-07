<form class="form form--35rem" action="register" method="post">
<?php

if (isset($exception)) {
    echo '<div class="form__exception">' . $exception . '</div><br>';
}

?>
    <label class="form__label">Nombre de Usuario:</label><br>
    <input class="form__field" type="text" name="username" required><br>
    <label class="form__label">Email:</label><br>
    <input class="form__field" type="email" name="email" required><br>
    <label class="form__label">Contraseña:</label><br>
    <input class="form__field" type="password" name="password" required><br>
    <label class="form__label">Repetir Contraseña:</label><br>
    <input class="form__field" type="password" name="password2" required><br>
    <div class="form__button-box">
        <input class="button" type="submit" name="submit" value="Regístrate">
        <p class="form__p"> o <a class="form__a" href="../auth/login">Inicia Sesión</a></p>
    </div>
</form>

