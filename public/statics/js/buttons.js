var menuVisibility = false;

var arrow = $('#arrow');
var cancelButton = $('#cancel');
var fav = $('#fav');

arrow.on( "click", () => {
    if (!menuVisibility) {
        $('.profile-menu__submenu').addClass('profile-menu__submenu--visible');
        menuVisibility = true;
    } else {
        $('.profile-menu__submenu').removeClass('profile-menu__submenu--visible');
        menuVisibility = false;
    }
});

cancelButton.on( "click", () => {
    $(location).attr('href', '..');
});
