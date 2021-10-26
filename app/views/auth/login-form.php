<form action="register" method="post">
<?php

    if (isset($params['exception'])) {
        echo '<div class="form-exception">' . $params['exception'] . '</div><br>';
    }

?>
    <fieldset>
        <label>Email:</label><br>
        <input type="email" class="auth-form" name="email" required><br>
        <label>Contraseña:</label><br>
        <input type="password" class="auth-form" name="" required><br>
        <input type="submit" value="Login">
    </fieldset>
    o <a href="../auth/register"> Registrate</a>
</form>