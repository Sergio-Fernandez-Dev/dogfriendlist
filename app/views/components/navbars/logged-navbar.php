<?php
$user = $_SESSION['user'];
?>

<header class="header">
    <div class="header__content">
    <h1 class="header__logo">
            <a class="header__link" href="..">DOGFRIENDLIST</a>
        </h1>
        <nav class="nav">
            <div class="nav__menu">
                <div class="nav__button">
                    <a class="nav__link" href="../new-spot">
                        <i class="material-icons">add_location_alt</i>
                    </a>
                </div>
                <div class="nav__button">
                    <a class="nav__link" href="../user/<?php echo $user['id'] ?>/favourites">
                        <span class="material-icons">favorite</span>
                    </a>
                </div>
            </div>
        </nav>
        <div class="profile-menu">
            <div class="profile-menu__box">
                <span class="material-icons profile-menu__picture">account_circle</span>
                <span class="p profile-menu__name"> <?php echo $user['username'] ?> </span>
                <span class="material-icons profile-menu__arrow" id="arrow">expand_more</span>
            </div>
                <!-- Menú desplegable -->
            <div class="profile-menu__submenu" id="profile-menu__submenu">
                <a class="nav__link nav__link--cascade" href="../auth/logout">Cerrar sesión</a>
            </div>
                <!-- fin menu desplegable -->
        </div>
    </div>

</header>



