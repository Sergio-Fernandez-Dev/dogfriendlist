function newMap() {

    chargeMap(true, 'new-spot-map');
}

function findNewSpot() {

    let address = $('input[name="address"]').val();
    let category = 0;
    let icon = Number($('select[name="category"]').val());

    getCoordinatesFromAddress(address, category, false, icon);
    
}

function sendForm() {

    let title = $('input[name="title"]').val();
    let category = Number($('select[name="category-new-spot"]').val());
    let coords = markerCoords;
    let address = getAddressFromCoordinates(coords);
    let description = $('input[name="description"]').val();

    $.post("../geolocation/charge-spots", {
        "title": title,
        "category": category,
        "coords": coords,
        "address": address,
        "description": description,
    });

}
