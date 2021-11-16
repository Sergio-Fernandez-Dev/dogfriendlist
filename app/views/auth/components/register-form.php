<form action="register" method="post">
<?php

if (isset($exception)) {
    echo '<div class="form-exception">' . $exception . '</div><br>';
}

?>
    <fieldset>
        <label>Nombre de Usuario:</label><br>
        <input type="text" class="auth-form" name="username" required><br>
        <label>Email:</label><br>
        <input type="email" class="auth-form" name="email" required><br>
        <label>Contraseña:</label><br>
        <input type="password" class="auth-form" name="password" required><br>
        <label>Repetir Contraseña:</label><br>
        <input type="password" class="auth-form" name="password2" required><br>
        <input type="submit" name="submit" value="Registrate">
        o <a href="../auth/login">Iniciar Sesión</a>
    </fieldset>
</form>

