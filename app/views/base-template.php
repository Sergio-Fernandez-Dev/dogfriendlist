
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../statics/css/normalize.css"/>
    <link rel="stylesheet" type="text/css" href="../statics/css/styles.css"/>
    </style>

    <title><?php echo 'Dogfriendlist - ' . $title ?></title>
</head>
<body class="body">

    <?php require_once $header;?>

    <?php include_once $main_content;?>

    <footer class="footer"></footer>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200&family=Ubuntu:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="../statics/js/geolocation/map.js"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB7qMBSnVThx9ylk-lVMZjn7xnnG6exRak&callback=initMap"
      async
    ></script>
</body>
</html>

