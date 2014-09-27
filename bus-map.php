<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Hackathon Buses</title>	
</head>
<body>

	<div id="panel"></div>
	<div id="map-canvas" style="width:100%; height:600px"></div>
	
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//maps.google.com/maps/api/js?v=3.exp"></script>
<script src="/nearby/linq.min.js"></script>
<script>
	var map;

	$(document).ready(function(){
			
		if(navigator.geolocation){
			navigator.geolocation.getCurrentPosition(initialize,function(){alert('Couldn\'t find your location')},{enableHighAccuracy:true,timeout:10000});
		} else {
			alert('Functionality not available');
		}
		
		function initialize(user) {	
			
			myLocation = {
				Latitude: user.coords.latitude.toFixed(5),
				Longitude: user.coords.longitude.toFixed(5)
			}
			
			var mapOptions = {
				zoom: 16,
				center: new google.maps.LatLng(myLocation.Latitude, myLocation.Longitude),
			  };

			map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
		
			myLocationMarker(myLocation);
			//getLiveBus();
			getNearbyStopPoints();
		}

	});
</script>
<script src="/app.js"></script>
</body>
</html>
