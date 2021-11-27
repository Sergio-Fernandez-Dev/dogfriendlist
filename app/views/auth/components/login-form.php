
<?php
if (isset($login_title)) {
    echo $login_title;
    echo '<span class="box__separation-line"></span>';
}
?>
    <form class="form form--35rem" action="login" method="post">
<?php
if (isset($exception)) {
    echo '<div class="form__exception">' . $exception . '</div><br>';
}
?>
        <label class="form__label">Email o nombre de usuario:</label><br>
        <input class="form__field" type="text" name="identification" required><br>
        <label class="form__label">Contraseña:</label><br>
        <input class="form__field" type="password" name="password" required><br>
        <label class="form__label">
            <input class="form__checkbox" type="checkbox" name="remember_me" value="true">
            Recuérdame
        </label><br>
        <div class="form__button-box">
            <input class="button" type="submit" name="submit" value="Login">
            <p class="form__p"> o <a href="../auth/register"> Regístrate</a></p>
        </div>
    </form>
</div>