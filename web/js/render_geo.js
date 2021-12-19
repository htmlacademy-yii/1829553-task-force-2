$(document).ready(function()
{
  ymaps.ready(init);
  function init(){
    if (lat && long) {
      var myMap = new ymaps.Map("map", {
        center: [lat, long],
        zoom: 17,
        controls: []
      });

      myGeoObject = new ymaps.GeoObject({
        geometry: {
          type: "Point",
          coordinates: [lat, long]
        },
      });

      myMap.geoObjects.add(new ymaps.Placemark([lat, long], {
        balloonContent: address
      }, {
        preset: 'islands#circleIcon',
        iconColor: '#3caa3c'
      }))
    }
  }
});
