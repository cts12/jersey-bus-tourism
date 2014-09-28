var infowindow = new google.maps.InfoWindow();
var marker, i;

function myLocationMarker(myLocation)
{
    // my Location Marker
    marker = new google.maps.Marker({
        position: new google.maps.LatLng(myLocation.Latitude, myLocation.Longitude),
        map: map,
        icon: 'nearby/Marker24-1.png'
    });

    google.maps.event.addListener(marker, 'click', (function (marker, i) {
        return function () {
            infowindow.setContent('Hello!');
            infowindow.open(map, marker);
        }
    })(marker, i));

}

function getLiveBus(myLocation) {

    var html = [];
    $.ajax({
        url: 'https://bus.data.je/latest',
        type: 'GET',
        dataType: 'json',
        beforeSend: setHeader,
        success: function (data) {

            /* loop through array */
            $.each(data, function (i, d) {


                var location = {
                    Latitude: d[0].loc.coordinates[1],
                    Longitude: d[0].loc.coordinates[0]
                }


                var direction = '';
                if (d[0].MonitoredVehicleJourney.DirectionRef == 'inbound')
                    direction = 'Going to Town'
                else
                    direction = 'Leaving Town'

                var line = {
                    lineRef: d[0].MonitoredVehicleJourney.LineRef,
                    direction: direction
                }

                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(location.Latitude, location.Longitude),
                    map: map,
                    icon: 'nearby/Marker24-2.png'
                });

                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infowindow.setContent('<p>Line: ' + line.lineRef + '</p><p>' + line.direction + '</p>');
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            });


        },
        error: function () { alert('boo!'); },

    });

    getNearbyStopPoints(myLocation);

}


function getNearbyStopPoints(myLocation) {

    var html = [];
    $.getJSON("bus-stops.json", function (data) {

        /* loop through array */
        $.each(data, function (index, d) {
            var dist = getDistanceInKm(myLocation.Latitude, myLocation.Longitude, d.Latitude, d.Longitude);
            html.push({ Name: d.Name, Latitude: d.Latitude, Longitude: d.Longitude, distance: dist });
        });

        var html2 = html.sort(SortByDistance);

        // nearby Markers
        for (i = 0; i < 5; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(html2[i].Latitude, html2[i].Longitude),
                map: map
            });

            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infowindow.setContent('' + html2[i].Name + '<br>' + html2[i].distance.toFixed(2) + 'km');
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }


    }).error(function (jqXHR, textStatus, errorThrown) { /* assign handler */
        /* alert(jqXHR.responseText) */
        alert("error occurred!");
    });

   
}

function getDistanceInKm(lat1, lon1, lat2, lon2) {
    var R = 6371; // Radius of the earth in km
    var dLat = deg2rad(lat2 - lat1);  // deg2rad below
    var dLon = deg2rad(lon2 - lon1);
    var a =
      Math.sin(dLat / 2) * Math.sin(dLat / 2) +
      Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
      Math.sin(dLon / 2) * Math.sin(dLon / 2)
    ;
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    var d = R * c; // Distance in km
    return d;
}

function deg2rad(deg) {
    return deg * (Math.PI / 180)
}

function SortByDistance(a, b) {
    var aName = a.distance;
    var bName = b.distance;
    return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
}


function setHeader(xhr) {
    xhr.setRequestHeader("Authorization", "Basic aGFja2F0aG9uZGVtbzpoYWNrYXRob25kZW1v");
}

function showRoutes(mylocation, destlocation) {

    //my closest bus stops
    //infor available are geo co-ordinates.
    var my_close_stops = closeRouteStops(mylocation);


    var dest_stops = closeRouteStops(destlocation);

    //get our markers and the destination markers

    for(var i = 0 ; i < my_close_stops.length ; i++){

        var my_stop = my_close_stops[i];
        var my_code = my_stop.Code;

        for(var j = 0 ; j < dest_stops.length ; j++){

            var dest_stop = dest_stops[j];
            var dest_code = dest_stop.Code;




        }
    }



    // google.maps.event.addListener(marker, 'click', (function (marker, i) {
    //             return function () {
    //                 infowindow.setContent('' + html2[i].Name + '<br>' + html2[i].distance.toFixed(2) + 'km');
    //                 infowindow.open(map, marker);
    //             }
    //         })(marker, i));
    //     }


}

function closeRouteStops(mylocation) {
    var html = [];
    $.getJSON("bus-stops.json", function (data) {

        /* loop through array */
        $.each(data, function (index, d) {
            var dist = getDistanceInKm(myLocation.Latitude, myLocation.Longitude, d.Latitude, d.Longitude);
            html.push({ Name: d.Name, Latitude: d.Latitude, Longitude: d.Longitude, distance: dist, code: d.Code });
        });

        var html2 = html.sort(SortByDistance);

        // nearby Markers
        // var markers = []
        // for (i = 0; i < 5; i++) {

        //     markers.push(marker = new google.maps.Marker({
        //         position: new google.maps.LatLng(html2[i].Latitude, html2[i].Longitude),
        //         map: map
        //     }));

        // }

        // return markers;

        return html2; 

    }).error(function (jqXHR, textStatus, errorThrown) { /* assign handler */
        /* alert(jqXHR.responseText) */
        alert("error occurred!");
    });



}