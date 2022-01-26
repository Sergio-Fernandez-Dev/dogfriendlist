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

    <title>Dogfriendlist - Reenviar clave</title>
</head>
<body class="body">
    <div class="box">
    <div class="box box--centered">
        <h2 class="h2">¡Algo ha salido mal!</h2><br><br>
        <p class="p">El enlace de activación no es correcto o ya ha expirado. Introduce tu dirección de correo
            y te lo enviaremos de nuevo.</p><br>
        <form class="form" action="/confirm" method="post">
        <input class="form__field form__field--finder-style" type="email"  name="email" placeholder="correo@ejemplo.com" required>
        <input class="button" type="submit" value="¡Reenvíamelo!">
        </form>
        </div>
    </div>
</body>
</html>
