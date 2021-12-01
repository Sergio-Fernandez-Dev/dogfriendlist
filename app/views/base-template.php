
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../statics/css/normalize.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200&family=Ubuntu:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../statics/css/styles.css"/>
    </style>

    <title><?php echo 'Dogfriendlist - ' . $title ?></title>
</head>
<body class="body">

<?php
// Si se ha establecido $base_page como true, cargamos la cabecera y el footer,
// si no solo cargaremos el contenido principal.
if ($base_page) {
    require_once $header;
}

include_once $main_content;

if ($base_page) {
    require_once $footer;
}

// Cargamos nuestros scripts dinámicamente
foreach ($scripts as $script) {
    require_once $script;
}

?>

</body>
</html>

