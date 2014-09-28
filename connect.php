<?php 
require 'app/views/header.php';
?>
 <!-- CONTENT SECTION -->
            <div id="content-home">

				<div id="panel"></div>
				<div id="map-canvas" style="width:100%; height:600px"></div>
				
				<button onclick="showResult()">Result</button>
				<div id="result">result</div>

            </div>
 <!-- END OF CONTENT SECTION -->
 <script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=geometry&amp;sensor=false"></script>
<script src="/nearby/linq.min.js"></script>
 <script>
	var mapdest;

	$(document).ready(function(){
			
		if(navigator.geolocation){
			navigator.geolocation.getCurrentPosition(initialize,errorhandler,{enableHighAccuracy:true,timeout:10000});
		} else {
			alert('Functionality not available');
		}

		function errorhandler(){

			if(true){

			setTimeout('initmap()', 1000);

			} else {
				// function(){alert('Couldn\'t find your location')};
			}
		}

		
		
		function initialize(user) {	
			
			setTimeout('initmap()', 1000);

		}

	});

	function initmap() {
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

			mapdest = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);

			var zooLocation = {

				Latitude: 49.2282821,
				Longitude: -2.0747125
				
			}
		
			showRoutes(myLocation, zooLocation);
		}
</script>
<script src="/app/js/new-app.js"></script>
<script src="/app/js/app.js"></script>

<?php require 'app/views/footer.php'; ?>