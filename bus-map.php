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
				<div id="map-canvas" style="width:100%"></div>

            </div>
 <!-- END OF CONTENT SECTION -->
	
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//maps.google.com/maps/api/js?v=3.exp"></script>
<script src="/nearby/linq.min.js"></script>
<script>
var map;

$(document).ready(function(){
	//get_start_selection();
		
	if(navigator.geolocation){
		navigator.geolocation.getCurrentPosition(initialize, get_start_selection(), {enableHighAccuracy:true,timeout:10000,maximumAge:60000});
	} else {
		alert('Functionality not available');
	}
	
	function initialize(user){
		
		//console.log(user);
		
		var myLocation = {
			Latitude: user.coords.latitude.toFixed(5),
			Longitude: user.coords.longitude.toFixed(5)
		};
		
		var mapOptions = {
			zoom: 17,
			center: new google.maps.LatLng(myLocation.Latitude, myLocation.Longitude),
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			mapTypeControl: false,
			streetViewControl: false,
			panControl: false
		};

		map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
	
		$('#map-canvas').css('background','none');
	
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
	
	function get_start_selection(){
		var stops = [];
		$.getJSON("bus-stops.json", function (data) {
			$.each(data, function (index, d) {
				stops.push({ Name: d.Name, Latitude: d.Latitude, Longitude: d.Longitude, Code: d.Code });
			});
			
			if(typeof stops == 'object'){
				var sortedStops = stops.sort(SortByName);
				
				var start_select = '<div id="start_journey"><form><div class="starting-point"><label for="start_select"> STARTING AT:</label> <select name="start_select"><option></option>';
				
				$.each(sortedStops, function(index, v){
					start_select += '<option value="' + v.Latitude + '|' + v.Longitude + '">' + v.Name + '</option>';					
				});
		
				start_select += '</select></div><div class="or">or</div><div class="code"><label for="start_code">ENTER CODE:</label> <input name="start_code" type="number" value="" maxlength="4"/> <button class="code-submit">Go</button></div></form></div>';
				
				$('#map-canvas').before(start_select);
			}
		});		
	}
	
	$(document).on('change','[name=start_select]',function(){
		var position = $(this).val();
		
		var coords = position.split('|');
		
		var startingPoint = {coords: {latitude: parseFloat(coords[0]), longitude: parseFloat(coords[1])}};
		
		initialize(startingPoint);
	});
	
	function SortByName(a, b) {
		var aName = a.Name,
			bName = b.Name;
		return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
	}
	
	$(document).on('submit',$('#start_journey form'),function(e){
		e.preventDefault();
		
		var code = $('[name=start_code]').val();
		
		if(code.length == 4){
			$.getJSON("bus-stops.json", function (data) {
				$.map(data,function(object){
					if(object.Code == code){
						var startingPoint = {coords: {latitude: parseFloat(object.Latitude), longitude: parseFloat(object.Longitude)}};
						
						initialize(startingPoint);
					}
				});
			});
		}
	});

	$(document).on('click','.stop-info a',function(e){
		e.preventDefault();
		var stopCode = $(this).data('code'),
			stopName = $(this).parent().find('p').html();
		
		$.ajax({
			url: 'https://bus.data.je/stops/' + stopCode + '/buses',
			type: 'GET',
			data: stopName,
			dataType: 'json',
			beforeSend: setHeader,
			success: function (data) {
			
				//console.log(data);
				
				var output = '<div id="results">';
				output += '<img src="/app/views/img/arrived_icon.png" alt=""/>';
				output += '<h2>' + stopName + '</h2>';
				
				var date = data.ETA;
				date = date.substring(0, date.length-6);
				
				var formattedDate = new Date(Date.parse(date));
				var h = formattedDate.getHours();
					h = h < 10 ? '0' + h : h;
				var m =  formattedDate.getMinutes();
					m = m < 10 ? '0' + m : m;
				var due = h + ":" + m;
				
				output += '<span class="route route_' + data.ServiceName + '"><span>' + data.ServiceName + '</span> to ' + data.Destination + ' @ ' + due + '</span>';
				
				output += '</div>';
				
				$('#container h1').html('Your Next Bus(es)');
				$('#start_journey').remove();
				$('#map-canvas').html(output);
			},
			error: function () {
				console.log('error :(');
				$('#map-canvas').html('Error!');
			}
		});
	});

});
</script>
<script src="/app/js/new-app.js"></script>

<?php 
require 'app/views/footer.php';