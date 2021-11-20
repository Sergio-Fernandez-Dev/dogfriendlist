
let map, userMarker;

function initMap() {
  //Creamos el marcador que nos mostrará la localización del usuario.
  userMarker = new google.maps.Marker('../statics/img/marker.png');

  $(document).ready(() => {
    // Creamos un mapa con las coordenadas por defecto.
    map = new google.maps.Map(document.getElementById("map"), {
      center: { lat: 40.416, lng: -3.703 },
      zoom: 14,
    });
    // Si el navegador permite la geolocalización
    if (navigator.geolocation) {
      // Obtenemos la posicion 
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
          };

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