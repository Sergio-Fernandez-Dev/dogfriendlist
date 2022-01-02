function newMap() {

    chargeMap(true);
}

function findNewSpot() {

    let address = $('input[name="address"]').val();
    let category = 0;
    let icon = Number($('select[name="category-new-spot"]').val());

    getCoordinatesFromAddress(address, category, false, icon);
}

