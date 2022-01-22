function chargeFavSpots() {
   chargeMap(false, 'fav-map');
}

function chargeFavs(map, category = 0) {
    clearMarkers();

    $.post( "../geolocation/charge-spots", {
        coords : { 
            lat : position["lat"], 
            lng : position["lng"] 
        },
        category : category
    })
    .done((result) => {

        spotList = JSON.stringify(result);
        console.log(spotList);

        var infowindow = new google.maps.InfoWindow({ maxWidth: 320 });    
        
        var length = spotList.length;

        for (var i = 0; i < length; i++) {

            const pos = {
            lat: parseFloat(spotList[i].lat),
            lng: parseFloat(spotList[i].lng),
            }

            const spotId = parseInt(spotList[i].id);

            let marker = new google.maps.Marker({
                id: spotId,
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

