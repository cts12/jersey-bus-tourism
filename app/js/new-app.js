var infowindow = new google.maps.InfoWindow();
var marker, i;

var journeyCodes = [];
var pointsOnRoute = [];
var pointsNearMe = [];


function myLocationMarker(myLocation) {
    // my Location Marker
    marker = new google.maps.Marker({
        position: new google.maps.LatLng(myLocation.Latitude, myLocation.Longitude),
        map: map,
        icon: '/app/views/img/Marker24-1.png'
    });

    google.maps.event.addListener(marker, 'click', (function (marker, i) {
        return function () {
            infowindow.setContent('<div id="user-location" class="map-info"><h2>You are here</h2></div>');
            infowindow.open(map, marker);
        }
    })(marker, i));

}

function getLiveBus() {

    var html = [];
    $.ajax({
        url: 'https://bus.data.je/latest',
        type: 'GET',
        dataType: 'json',
        beforeSend: setHeader,
        success: function (data) {

            /* loop through array */
            $.each(data, function (i, d) {

                var LineRef = d[0].MonitoredVehicleJourney.LineRef;
                var DirectionRef = d[0].MonitoredVehicleJourney.DirectionRef;

                var journey = Enumerable.From(journeyCodes)
                    .Where(function (x) { return x.LineRef == LineRef })
                    .Where(function (x) { return x.RouteSections_Direction == DirectionRef })
                    .Select(function (x) { return x.Routes_Description })
                    //.Select(function (x) { return x.Services_StandardService_Origin + ' - ' + x.Services_StandardService_Destination })
                    .ToArray();

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
                    icon: '/app/views/img/Marker24-2.png'
                });

                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infowindow.setContent('<div class="map-info bus-info"><p>' + journey[0] + '</p><p>Line: ' + line.lineRef + '</p><p>' + line.direction + '</p></div>');
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            });


        },
        error: function () { console.log('error :('); },

    });


}

function getGeo(myLocation) {

    var html = [];
    $.ajax({
        url: 'https://bus.data.je/geo/' + myLocation.Latitude + '/' + myLocation.Longitude,
        type: 'GET',
        dataType: 'json',
        beforeSend: setHeader,
        success: function (data) {


            /* loop through array */
            $.each(data, function (i, d) {


                var location = {
                    Latitude: d.loc.coordinates[1],
                    Longitude: d.loc.coordinates[0]
                }


                var direction = '';
                if (d.MonitoredVehicleJourney.DirectionRef == 'inbound')
                    direction = 'Going to Town'
                else
                    direction = 'Leaving Town'

                var line = {
                    lineRef: d.MonitoredVehicleJourney.LineRef,
                    direction: direction
                }

                pointsNearMe.push(line);

                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(location.Latitude, location.Longitude),
                    map: map,
                    icon: '/app/views/img/Marker24-3.png'
                });

                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infowindow.setContent('<p>Line: ' + line.lineRef + '</p><p>' + line.direction + '</p>');
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            });


        },
        error: function () { console.log('error :('); },

    });

}

function getNearbyStopPoints(myLocation) {

    var html = [];
    $.getJSON("bus-stops.json", function (data) {

        /* loop through array */
        $.each(data, function (index, d) {
            var dist = getDistanceInKm(myLocation.Latitude, myLocation.Longitude, d.Latitude, d.Longitude);
            html.push({ Name: d.Name, Latitude: d.Latitude, Longitude: d.Longitude, distance: dist, Code: d.Code });
        });

        var html2 = html.sort(SortByDistance);

        // nearby Markers
        for (i = 0; i < 16; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(html2[i].Latitude, html2[i].Longitude),
                map: map
            });

            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
					var howFar = html2[i].distance;
					
					if(howFar < 1)
						howFar = (html2[i].distance * 1000).toFixed(0) + 'm';
					else
						howFar += 'km';
						
                    infowindow.setContent('<div class="map-info stop-info"><p>' + html2[i].Name + '</p><p>' + howFar + '</p><a href="#" data-code="' + html2[i].Code + '">Select</a></div>');
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }


    }).error(function (jqXHR, textStatus, errorThrown) { /* assign handler */
        /* alert(jqXHR.responseText) */
        console.log("error occurred!");
    });

   
}

function getNearbyStopPoints2(myLocation,place) {

	var journey = Enumerable.From(journeyCodes)
                .Where(function (x) { return x.Destination == place })
                .Select(function (x) { return x.Latitude + ':' + x.Longitude + ':' + x.LineRef })
                .ToArray();
				
    var points = [];

	if(journey.length){
		/* loop through array */
		$.each(journey, function (index, d) {

			var cord = d.split(':');

			var dist = getDistanceInKm(myLocation.Latitude, myLocation.Longitude, cord[0], cord[1]);
			points.push({ Latitude: cord[0], Longitude: cord[1], distance: dist, lineRef: cord[2] });
		});
		   
		points.sort(SortByDistance);
	}

	
	if(points.length){
		// nearby Markers
		for (i = 0; i < 5; i++) {

			pointsOnRoute.push(points[i]);
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(points[i].Latitude, points[i].Longitude),
				map: map
			});

			google.maps.event.addListener(marker, 'click', (function (marker, i) {
				return function () {
					infowindow.setContent('Line: ' + pointsOnRoute[i].lineRef + '<br>');
					infowindow.open(map, marker);
				}
			})(marker, i));
		}
	}

}

function getJourneyCodes(callback) {

    
    var html = [];
    $.ajax({
        url: 'routes.json',
        async: false,
        type: 'GET',
        dataType: 'json',
        beforeSend: setHeader,
        success: function (data) {
            journeyCodes = data;
        },
        error: function () { console.log('error :('); },

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


function showResult() {
    var a = pointsOnRoute;
    var b = pointsNearMe;

    var same = true;

    $.each(pointsOnRoute, function (i, a) {

        $.each(pointsNearMe, function (j, b) {

            same = (a.lineRef == b.lineRef);

            if (same == false)
                return false;
        })

    })

    if (same == false) {
        $('#result').html(pointsNearMe[0].lineRef);
        $('#result').append('  -  ');
        $('#result').append(pointsOnRoute[0].lineRef);
    }
    else
    {
        $('#result').html(pointsNearMe[0].lineRef);
    }
}

function getCloseStopPoints(myLocation) {

    var html = [];
    $.getJSON("bus-stops.json", function (data) {

        /* loop through array */
        $.each(data, function (index, d) {
            var dist = getDistanceInKm(myLocation.Latitude, myLocation.Longitude, d.Latitude, d.Longitude);
            html.push({ Name: d.Name, Latitude: d.Latitude, Longitude: d.Longitude, distance: dist, Code: d.Code });
        });
        console.log(3);
        var html2 = html.sort(SortByDistance);
        return html2;
        // nearby Markers
        // for (i = 0; i < 5; i++) {
        //     console.log(html[i].Code);
        //     marker = new google.maps.Marker({
        //         position: new google.maps.LatLng(html2[i].Latitude, html2[i].Longitude),
        //         map: map
        //     });

        //     google.maps.event.addListener(marker, 'click', (function (marker, i) {
        //         return function () {
        //             infowindow.setContent('' + html2[i].Name + '<br>' + html2[i].distance.toFixed(2) + 'km');
        //             infowindow.open(map, marker);
        //         }
        //     })(marker, i));
        // }


    }).error(function (jqXHR, textStatus, errorThrown) { /* assign handler */
        /* alert(jqXHR.responseText) */
        console.log("error occurred!");
    });

   
}