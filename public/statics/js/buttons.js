var menuVisibility = false;

$('#arrow').hover( () => {
    $('#arrow').addClass('profile-menu__arrow--hover');

}, () => {
    $('#arrow').removeClass('profile-menu__arrow--hover');
})

$('#arrow').on( "click", () => {
    if (!menuVisibility) {
        $('.profile-menu__submenu').addClass('profile-menu__submenu--visible');
        menuVisibility = true;
    } else {
        $('.profile-menu__submenu').removeClass('profile-menu__submenu--visible');
        menuVisibility = false;
    }
});
