
<form action="login" method="post">
<?php

if (isset($exception)) {
    echo '<div class="form-exception">' . $exception . '</div><br>';
}

?>
    <fieldset>
        <label>Email o nombre de usuario:</label><br>
        <input type="text" class="auth-form" name="identification" required><br>
        <label>Contraseña:</label><br>
        <input type="password" class="auth-form" name="password" required><br>
        <label><input type="checkbox" name="remember_me" value="true">Recuérdame</label><br>
        <input type="submit" name="submit" value="Login"> o <a href="../auth/register"> Regístrate</a>
    </fieldset>

</form>