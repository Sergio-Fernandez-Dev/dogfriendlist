<?php
$user = $_SESSION['user'];
$profile_img = $user->getImg();
?>

<header class="header">
    <h1 class="header__logo">DOGFRIENDLIST</h1>
    <nav class="nav">
        <div class="nav__menu">
            <div class="nav__button">
                <a class="nav__link" href="../spot/new">
                    <i class="material-icons large">add_location_alt</i>
                </a>
            </div>
            <div class="nav__button">
                <a class="nav__link" href="../user/favourites">
                    <span class="material-icons md-36">favorite</span>
                </a>
            </div>
        </div>
    </nav>
    <div class="header__profile">
        <img src="<?php echo $profile_img; ?>">
    </div>
        <!-- Menú desplegable -->
    <div class="header__submenu">
        <a class="nav__link nav__link--cascade" href="#">Mi perfil</a>
        <a class="nav__link nav__link--cascade" href="#">Mis spots</a>
        <a class="nav__link nav__link--cascade" href="../auth/logout">Cerrar sesión</a>
    </div>
         <!-- fin menu desplegable -->

</header>



