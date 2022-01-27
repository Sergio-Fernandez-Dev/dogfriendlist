function chargeFavSpots() {
   chargeMap(false, 'fav-map');
}

function chargeFavs(map, category = 0) {
    clearMarkers();
    ('Entra en chargeFavs')
    $.post( "../geolocation/charge-fav-spots", {
        category : category
    })
    .done((result) => {

        spotList = JSON.parse(result);
        (spotList);

        var infowindow = new google.maps.InfoWindow({ maxWidth: 320 });    
        
        var length = spotList.length;

        for (var i = 0; i < length; i++) {

            const pos = {
            lat: parseFloat(spotList[i].lat),
            lng: parseFloat(spotList[i].lng),
            }

            const spotId = parseInt(spotList[i].id);
            const spotCategory = parseInt(spotList[i].category_id);

            let marker = new google.maps.Marker({
                id: spotId,
                category: spotCategory,
                position: pos,
                map: map
            });

            let icon = selectMarkerType(spotList[i].category_id);
            marker.setIcon(icon);
            attachInfowindow(spotList[i].title, spotList[i].description, marker, map, infowindow); 

            markers.push(marker);
        }
    })       
}

function hideMarkers() {

    const category = Number($('select[name="fav-category"]').val());
    var length = spotList.length;

    if (category == 1) {
        for (var i = 0; i < length; i++) {
            markers[i].setMap(map);
        }
    } else {
        for (var i = 0; i < length; i++) {
            if (markers[i].category != category) {
                markers[i].setMap(null);
            } else {
                markers[i].setMap(map);
            }
        }
    }
}

