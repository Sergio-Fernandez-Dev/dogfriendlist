var menuVisibility = false;

var arrow = $('#arrow');

arrow.on( "click", () => {
    if (!menuVisibility) {
        $('.profile-menu__submenu').addClass('profile-menu__submenu--visible');
        menuVisibility = true;
    } else {
        $('.profile-menu__submenu').removeClass('profile-menu__submenu--visible');
        menuVisibility = false;
    }
});
