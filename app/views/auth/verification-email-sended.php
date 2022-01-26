<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../statics/css/normalize.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../statics/css/styles.css"/>

    <title>Dogfriendlist - Confirmación</title>
</head>
<body class="body">
    <div class="box">
        <div class="box box--centered">
            <h2 class="h2">Un email de confirmación ha sido enviado a tu correo</h1><br>
            <p class="p">¡Gracias por unirte a nuestra gran familia! Acabamos de enviarte un mensaje de confirmacion a</p>
            <p class="p p--bold"><?php echo $user['email'] ?></p><br>
            <p class="p">Si en unos minutos no lo has recibido, haz click en el siguiente botón
                y te lo enviaremos de nuevo.
            </p><br><br>
            <form class="form" action="confirm" method="post">
            <input class="button" type="submit" value="¡Reenvíamelo!">
            </form>
        </div>
    </div>
</body>
</html>