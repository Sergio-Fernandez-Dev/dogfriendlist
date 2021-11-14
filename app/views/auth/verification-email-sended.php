<h1>Un email de confirmación ha sido enviado a tu correo</h1>
<p>¡Gracias por unirte a nuestra gran familia! Acabamos de enviarte un mensaje de confirmacion a
    <b><?php echo $user->getEmail() ?></b>.<br>
    Si en unos minutos no lo has recibido, haz click en el siguiente botón
    y te lo enviaremos de nuevo.
</p>
<form action="confirm" method="post">
<input type="submit" value="¡Reenvíamelo!">
</form>


