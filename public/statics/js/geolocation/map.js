
let map, userMarker;

function initMap() {

  //Creamos el marcador que nos mostrará la localización del usuario.
  const userMarker = new google.maps.Marker();
  userMarker.setIcon('../statics/img/marker2.png');

  // Creamos un mapa con las coordenadas por defecto.
  const map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 40.416, lng: -3.703 },
    zoom: 16,
    mapId: "1b3b30d8e6caa90",
  });

  $(document).ready(() => {

    // Si el navegador permite la geolocalización
    if (navigator.geolocation) {
      // Obtenemos la posicion
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
          };
          //Obtenemos la dirección correspondiente a las coordenadas recibidas.
          getAddressFromCoordinates(pos);
          chargeNearSpots(pos, map)

          // Colocamos nuestro marcador de usuario en la posición obtenida del navegador.

          userMarker.setPosition(pos);
          userMarker.setMap(map);
          map.setCenter(pos);

        },
        // Si no podemos establecer la posición llamamos a handleLocationError
        () => {
          handleLocationError(true, userMarker, map.getCenter());
        }
      );
    // Si el navegador no permite la geolocalización
    } else {
      // Llamamos a handleLocationError
      handleLocationError(false, userMarker, map.getCenter());
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
  userMarker.setMap(map);
}

//Obtenemos la dirección corespondiente a las coordenadas recibidas y la insertamos
//en el placeholder de nuestro buscador.
function getAddressFromCoordinates(position){

  const geocoder = new google.maps.Geocoder();

  geocoder.geocode({ location: position })
    .then((response) => {
      if (response.results[0]) {
        const address = response.results[0].formatted_address;
        const placeholder = document.querySelector('#index-finder');
        placeholder.removeAttribute('placeholder');
        placeholder.setAttribute('placeholder', address);
      }
    }
  );
}

function chargeNearSpots( position, map ) {
  $.post( "../geolocation/charge-near-spots", 
    {"coords" : { "lat" : position["lat"], "lng" : position["lng"] }})
    .done(function( result ) {
      
      var spots = JSON.parse(result);
      var spot_list = [];
      var length = spots.length;

      for (var i = 0; i < length; i++) {

        const pos = {
          lat: parseFloat(spots[i].lat),
          lng: parseFloat(spots[i].lng),
        }

        let title = spots[i].title;

        let marker = new google.maps.Marker({
          position: pos,
          map: map
        });

      

      }

    })
  
}
