document.addEventListener("DOMContentLoaded", function () {
  if (document.getElementById("map")) {
    let map;

    const mapContainer = document.getElementById("map");

    mapContainer.style.height = "21.5rem";

    const lat = parseInt(document.querySelector(".google-map-container__map").dataset.lat);
    const lng = parseInt(document.querySelector(".google-map-container__map").dataset.lng);
    const zoom = parseInt(document.querySelector(".google-map-container__map").dataset.zoom);
    const address = document.querySelector(".google-map-container__map").dataset.address;

    const lating = { lat: lat, lng: lng };

    map = new google.maps.Map(mapContainer, {
      zoom: zoom,
      center: lating,
    });

    new google.maps.Marker({
      position: lating,
      map,
      title: address,
    });

    google.maps.event.addListenerOnce(map, "idle", () => {
      document.getElementsByTagName("iframe")[0].title = "Google Maps";
    });
  }
});
