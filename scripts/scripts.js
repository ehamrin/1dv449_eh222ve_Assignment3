$(function(){

    var events = [];
    var latitude = 58.383836;
    var longitude = 12.322560;
    var zoom = 7;

    function UpdateEvents(){
        var element = $("#events");

        element.html("<ul></ul>");
        var list = element.find("ul");

        function Success(response){
            events = JSON.parse(response);

            events.forEach(function(el){
                list.prepend('<li><a href="#" class="event-link" data-id="' + el.id + '">' + el.title + '</a></li>');
            });

            UpdateMap();
        }


        $.ajax({
            url: "api/Traffic",
            success: Success
        });
    }

    var map = L.map('map').setView([latitude, longitude], zoom).locate();

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var markers = [];
    var popups = [];

    function getMarkerHTML(el){
        return '<h2>' + el.title + '</h2>' +
            '<p class="date">' + el.created + '</p>' +
            '<p class="description">' + el.description + '</p>';
    }

    $('#events').click(function(e){
        e.preventDefault();
        var id = $(e.target).data("id");
        map.setView(markers[id].getLatLng());
        markers[id].openPopup(popups[id]);

    });

    function UpdateMap(){
        events.forEach(function(el){
            var marker = L.marker([el.latitude, el.longitude],{
                    draggable: false,
                    title: el.title
                });

            marker.addTo(map);

            markers[el.id] = marker;

            var popup = L.popup();
            popup.setContent(getMarkerHTML(el));
            marker.bindPopup(popup);

            popups[el.id] = popup;
        });
    }

  /*  function showPosition(position){
        map.setView([latitude, longitude]);
    }

    navigator.geolocation.getCurrentPosition(showPosition);
*/
    UpdateEvents();

});