<?php
$user = $_SESSION['user'];
$profile_img = $user->getImg();
?>

<header class="header">
    <div class="header__content">
        <h1 class="header__logo">DOGFRIENDLIST</h1>
        <nav class="nav">
            <div class="nav__menu">
                <div class="nav__button">
                    <a class="nav__link" href="../spot/new">
                        <i class="material-icons">add_location_alt</i>
                    </a>
                </div>
                <div class="nav__button">
                    <a class="nav__link" href="../user/favourites">
                        <span class="material-icons">favorite</span>
                    </a>
                </div>
            </div>
        </nav>
        <div class="profile-menu">
            <div class="profile-menu__picture">
                <a class="nav__link" href="../user/favourites">
                    <span class="material-icons">account_circle</span>
                    <span class="material-icons">expand_more</span>
                </a>
            </div>
                <!-- Menú desplegable -->
            <div class="profile-menu__submenu">
                <a class="nav__link nav__link--cascade" href="#">Mi perfil</a>
                <a class="nav__link nav__link--cascade" href="#">Mis spots</a>
                <a class="nav__link nav__link--cascade" href="../auth/logout">Cerrar sesión</a>
            </div>
                <!-- fin menu desplegable -->
        </div>
    </div>

</header>



