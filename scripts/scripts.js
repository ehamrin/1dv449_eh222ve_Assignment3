function setCookie(c_name, value, exdays) {
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value = value + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
    document.cookie = c_name + "=" + c_value;
}

function getCookie(c_name) {
    var i, x, y, ARRcookies = document.cookie.split(";");
    for (i = 0; i < ARRcookies.length; i++) {
        x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
        y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
        x = x.replace(/^\s+|\s+$/g, "");
        if (x == c_name) {
            return y;
        }
    }
}


var App = {
    events: [],
    latlng: [58.383836, 12.322560],
    zoom: 7,
    map: undefined,
    markers: [],
    popups: [],
    category: [],
    layers: [],

    Init: function(){
        App.map = L.map('map').setView(App.latlng, App.zoom);

        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: ''
        }).addTo(App.map);

        $('#event-list').click(function(e){
            e.preventDefault();
            var id = $(e.target).data("id");
            if(id !== undefined){
                App.map.panTo(App.markers[id].getLatLng());
                App.markers[id].openPopup(App.popups[id]);
            }else{
                console.error('marker with id: ' + id + ' doesnt exist');
            }
        });

        $('.category-option').click(function(e){
            e.preventDefault();
            var element = $(e.target);
            var id = element.data("category");

            element.toggleClass("show");

            if(id !== undefined && App.category[id] != undefined){
                App.category[id].forEach(function(el){
                    if(element.hasClass("show")){
                        App.map.addLayer(el);
                    }else{
                        App.map.removeLayer(el);
                    }
                });

            }
        });

        $('#event_controller').click(function(e){
            $('body').toggleClass('active');
        });

        App.UpdateEvents();
        App.GetLocation();
    },

    UpdateEvents: function(){

        function Success(response){

            App.events = response;
            App.DrawUI();
        }


        $.ajax({
            url: "api/Traffic",
            success: Success
        });
    },

    HasLocation: function() {
        return getCookie("geolocation");
    },

    SaveLocation: function SaveLocation(latlng){
        setCookie("geolocation", JSON.stringify(latlng), 100);
    },

    GetLocation: function(){

        if(App.HasLocation() == undefined){
            if("geolocation" in navigator){
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        App.latlng = [position.coords.latitude, position.coords.longitude];
                        //App.SaveLocation(App.latlng);
                        App.map.panTo(App.latlng);
                    }
                );
            }

        }else{
            App.map.panTo(JSON.parse(App.HasLocation()));
        }
    },

    DrawUI: function(){
        var element = $("#event-list");

        var icons = [1,2,3,4,5];
        for(i = 1; i <= 5; i++){
            var icon = L.Icon.Default.extend({
                options: {
                    iconUrl: '/images/marker-icon-' + i + '.png'
                }
            });

            icons[i] = new icon();
        }

        App.events.forEach(function(el){

            element.prepend('<li><a href="#" class="event-link" data-id="' + el.id + '">' + el.title + '</a></li>');

            var marker = L.marker([el.latitude, el.longitude],{
                draggable: false,
                title: el.title,
                icon: icons[el.priority]
            });

            if(App.category[el.category] == undefined){
                App.category[el.category] = [];
            }

            App.category[el.category][el.id] = marker;
            App.map.addLayer(marker);
            //marker.addTo(App.map);

            App.markers[el.id] = marker;

            var popup = L.popup();
            popup.setContent(App.getMarkerHTML(el));
            marker.bindPopup(popup);

            App.popups[el.id] = popup;
        });
    },

    getMarkerHTML: function(el){
        return '<h2>' + el.title + '</h2>' +
            '<p class="date">' + el.created + '</p>' +
            '<p>Prioritet: ' + el.priority + '</p>' +
            '<p class="description">' + el.description + '</p>';
    }

};

$(function(){
    App.Init();

});