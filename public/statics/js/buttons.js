var menuVisibility = false;
var clicked;
const arrow = $('#arrow');
const cancelButton = $('#cancel');


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

$(document).on('mouseover', '.fav__button', function(){
    $(this).addClass('fav__button--hover');
  });

$(document).on('mouseleave', '.fav__button', function(){
  if (!clicked) {
      $(this).removeClass('fav__button--hover');
  }
});

$(document).on('click', '.fav__button', function(){
    if (!clicked) {
        $(this).text('favorite');
        $(this).addClass('fav__button--clicked');
        clicked = true;
        addToFavorite(markerId);
    } else {
        $(this).text('favorite_border');
        $(this).removeClass('fav__button--clicked');
        clicked = false;
        removeFromFavorite(markerId);
    }
  });
