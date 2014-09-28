<?php
$meta = array(
	'title' => 'Your Nearest Bus Stops',
	'description' => '',
	'keywords' => ''
);
$heading = 'YOUR NEAREST BUS STOPS';

require 'app/views/header.php' ;
?>
 <!-- CONTENT SECTION -->
            <div id="content-home">

				<div id="panel"></div>
				<div id="map-canvas" style="width:100%; height:600px"></div>
				
				<button onclick="showResult()">Result</button>
				<div id="result">result</div>

            </div>
 <!-- END OF CONTENT SECTION -->
	
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//maps.google.com/maps/api/js?v=3.exp"></script>
<script src="/nearby/linq.min.js"></script>
<script>
	var map;

	$(document).ready(function(){
			
		if(navigator.geolocation){
			navigator.geolocation.getCurrentPosition(initialize,errorhandler,{enableHighAccuracy:true,timeout:10000});
		} else {
			alert('Functionality not available');
		}

		function errorhandler(){

			if(true){

				var myLocation = {
				// Latitude: user.coords.latitude.toFixed(5),
				// Longitude: user.coords.longitude.toFixed(5)
				Latitude: 49.1778315,
				Longitude: -2.0810084
			}
			
			var mapOptions = {
				zoom: 16,
				center: new google.maps.LatLng(49.1778315, -2.0810084),
				mapTypeId: google.maps.MapTypeId.ROADMAP
			  };

			map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
		
			myLocationMarker(myLocation);
			//getLiveBus(myLocation);
			getNearbyStopPoints(myLocation);

			} else {
				// function(){alert('Couldn\'t find your location')};
			}
		}
		
		function initialize(user) {	
			
			var myLocation = {
				Latitude: user.coords.latitude.toFixed(5),
				Longitude: user.coords.longitude.toFixed(5)
			}
			
			var mapOptions = {

				zoom: 16,
				center: new google.maps.LatLng(myLocation.Latitude, myLocation.Longitude),
				mapTypeId: google.maps.MapTypeId.ROADMAP
			  };

			map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
		
			myLocationMarker(myLocation);
			getJourneyCodes();
			getLiveBus();
			getNearbyStopPoints(myLocation);
			//getGeo(myLocation);
            
            //Corbiere
            //L'Etacq
            //Durrell
            //Bus Station
            //Gorey Pier
            //getNearbyStopPoints2(myLocation);

		}

	});
</script>
<script src="/app/js/new-app.js"></script>

<?php 
require 'app/views/footer.php';