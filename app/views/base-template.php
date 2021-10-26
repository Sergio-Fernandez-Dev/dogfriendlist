
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo 'Dogfriendlist - ' . $params['title'] ?></title>
</head>
<body>
    <header>
        <?php
            require $header;
        ?>
    </header>
    <h2>MAIN:</h2>

    <?php include $main_content?>
    <footer>FOOTER</footer>
</body>
</html>