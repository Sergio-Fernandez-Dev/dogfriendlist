
let map;
let userMarker;
let spot_list;
let markers = [];


function initMap() {
    $('#map').append('<p class="map__p">CARGANDO MAPA...</p>');

    $(document).ready(() => {
        //Creamos el marcador que nos mostrará la localización del usuario.
        const userMarker = new google.maps.Marker({
            zIndex: 1000000
        });
        
        userMarker.setIcon('../statics/img/markers/marker-user.svg');

        //Establecemos coordenadas por defecto.
        let pos = {
            lat: 40.415,
            lng: -3.684
        };

        // Si el navegador permite la geolocalización
        if (navigator.geolocation) {
        // Obtenemos la posicion
        navigator.geolocation.getCurrentPosition(
            (position) => {
            pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude,
            };
            //Creamos un mapa con las coordenadas del usuario
            map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: pos.lat, lng: pos.lng },
                zoom: 17,
                scrollwheel: true,
                mapId: "1b3b30d8e6caa90",
            });
            //Obtenemos la dirección correspondiente a las coordenadas recibidas.
            getAddressFromCoordinates(pos);
            chargeSpots(pos, map)

            // Colocamos nuestro marcador de usuario en la posición obtenida del navegador.

            userMarker.setPosition(pos);
            userMarker.setMap(map);

            },
            // Si no podemos establecer la posición llamamos a handleLocationError
            () => {
            handleLocationError(true, userMarker, pos);
            }
        );
        // Si el navegador no permite la geolocalización
        } else {
        // Creamos un mapa con las coordenadas por defecto.
            map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: pos.lat, lng: pos.lng },
                zoom: 17,
                mapId: "1b3b30d8e6caa90",
            });

            getAddressFromCoordinates(pos);
            chargeSpots(pos, map);
            // Llamamos a handleLocationError
            handleLocationError(false, userMarker, pos);
            }
        });
}

// En caso de no poder obtener la posición del usuario, crea un marcador con una etiqueta de advertencia.
function handleLocationError(browserHasGeolocation, userMarker, pos) {

    userMarker.setPosition(pos);
    userMarker.setLabel(
        browserHasGeolocation
        ? "Advertencia: Activa la geolocalización para una mejor experiencia."
        : "Error: El navegador no permite la geolocalización."
    );
    //Creamos un mapa con las coordenadas por defecto
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: pos.lat, lng: pos.lng },
        zoom: 17,
        scrollwheel: true,
        mapId: "1b3b30d8e6caa90",
    });

    getAddressFromCoordinates(pos);
    chargeSpots(pos, map);
    userMarker.setMap(map);
}

//Obtenemos la dirección corespondiente a las coordenadas recibidas y la insertamos
//en el placeholder de nuestro buscador.
function getAddressFromCoordinates(position) {

    const geocoder = new google.maps.Geocoder();

    geocoder.geocode({
        location: position,
        region: 'es'
    })
    .then((response) => {
        if (response.results[0]) {
            const address = response.results[0].formatted_address;
            const placeholder = document.querySelector('#finder-input');
            placeholder.removeAttribute('placeholder');
            placeholder.setAttribute('placeholder', address);
        }
    });
}


function getCoordinatesFromAddress(address, category) {
    //vaciamos la lista de marcadores 
    
    let pos;

    const geocoder = new google.maps.Geocoder();

    geocoder.geocode({ 
        address: address,
        region: 'es'
    }, 
    (results, status) => {
        if (status == 'OK') {
            map.setCenter(results[0].geometry.location);
            map.setZoom(17);

            const position = {
                lat: results[0].geometry.location.lat,
                lng: results[0].geometry.location.lng
            }

            chargeSpots(position, map, category);

            let marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });

            markers.push(marker);

            
        
        } else if (status == 'INVALID_REQUEST') {
            alert('La dirección solicitada no existe');
        } else {
            alert('Algo ha salido mal, inténtalo de nuevo');
        }      
    });
}
        

function prepareFinderQuery() {

    let address = $('#finder-input').val();
    let category = $('#finder-category').val();
    
    getCoordinatesFromAddress(address, category);    
}


function checkEnterIsPressed(e) {

    if (e.key == 'Enter') {
        prepareFinderQuery();
    }
}


function chargeSpots(position, map, category = 0) {

    clearMarkers();

    $.post( "../geolocation/charge-spots", {
        "coords" : { 
            "lat" : position["lat"], 
            "lng" : position["lng"] 
        },
        "category" : category
    })
    .done((result) => {

        spot_list = JSON.parse(result);

        var infowindow = new google.maps.InfoWindow();    
        
        var length = spot_list.length;

        for (var i = 0; i < length; i++) {

            const pos = {
            lat: parseFloat(spot_list[i].lat),
            lng: parseFloat(spot_list[i].lng),
            }

            let marker = new google.maps.Marker({
            position: pos,
            map: map
            });
            let icon = selectMarkerType(spot_list[i].category_id);
            marker.setIcon(icon);
            attachInfowindow(spot_list[i].title, spot_list[i].description, marker, map, infowindow);
            
            markers.push(marker);
        }
    })       
}


function clearMarkers() {

    for (let i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
    }
    markers = [];
}


function selectMarkerType(categoryId) {

    switch (categoryId) {
        case 2:
        return '../statics/img/markers/marker-park.svg';
        case 3:
        return '../statics/img/markers/marker-beach.svg';
        case 4:
        return '../statics/img/markers/marker-accommodation.svg';
        case 5:
        return '../statics/img/markers/marker-restaurant.svg';
        case 6:
        return '../statics/img/markers/marker-petshop.svg';
        case 7:
        return '../statics/img/markers/marker-clinic.svg';
        case 8:
        return '../statics/img/markers/marker-daycare.svg';
        case 9:
        return '../statics/img/markers/marker-others.svg';
    }
}

function attachInfowindow(title, description, marker, map, infowindow) {
    
    let infowindowHTML = 
                '<div class="infowindow">' +
                    '<h1 class="infowindow__title" id="infowindow-title">' + 
                        title + 
                    '</h1>' +
                    '<div class="infowindow__description" id="infowindow-description">' + 
                        description + 
                    '</div>' +
                '</div>';
    
    
    var lastInfowindow = false;  

    marker.addListener("click",  () => {
        if (lastInfowindow) {
            infowindow.close();
        }

        infowindow.setContent(infowindowHTML);
        infowindow.open({
            anchor: marker,
            map: map,
            shouldFocus: false,
        });

        lastInfowindow = infowindow;
    });
}

