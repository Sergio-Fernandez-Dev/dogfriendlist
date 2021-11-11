<h1>Un email de confirmación ha sido enviado a tu correo</h1>
<p>¡Gracias por unirte a nuestra gran familia! Acabamos de enviarte un mensaje de confirmacion a
    <b><?php $user->getEmail?></b>.<br>
    Si en unos minutos no lo has recibido, haz click en el siguiente botón
    y te lo enviaremos de nuevo.
</p>
<a href="../auth/confirm"><div class="main-button" id="resend-validation-button">¡Reenvíamelo!<</div></a>
<p><?php echo $params['msg'] ?></p>
