<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Hackathon Buses</title>
</head>
<body>

	<div id="output">Initializing...</div>
	<div id="gmap" style="width:100%; height:600px"></div>
	
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="/app/js/maplace-0.1.3.min.js"></script>
<script type="text/javascript">
$(function(){	
	$.ajax({ 
		type: 'GET', 
		url: 'bus-stops.json', 
		dataType:'json',
		beforeSend:function(){},
		success: function (data) { 
			//console.log(data);
			get_stop_positions(data);
		},
		error: function(data){
			console.log('Error: ' + data);
		}
	});
	
	
	function get_user_location(){
		var output = $('output');
		
		if(navigator.geolocation){
			output.html('Receiving...');
			navigator.geolocation.getCurrentPosition(get_user_position,function(){output.html('Couldn\'t find your location')},{enableHighAccuracy:true,timeout:10000});
		} else{
			output.html('Functionality not available');
		}
		
		return;
	}
	
	function get_user_position(user){
		
		var userLocation = [{
			lat: user.coords.latitude.toFixed(5), 
			lon: user.coords.longitude.toFixed(5),
			title: 'You are here'
		}];
	
		return userLocation;
	}
	
	function get_stop_positions(stops){
	
		var stopLocations = [];
		if(typeof stops == 'object'){
			
			$(stops).each(function(k,stop){
				var busStops = {};
				
				busStops['lat'] = stop.Latitude;
				busStops['lon'] = stop.Longitude;
				busStops['title'] = 'Bus Stop: ' + stop.Code + ' : ' + stop.Name;
				
				stopLocations.push(busStops);
			});
			
			var userLocation = get_user_position();

			console.log(userLocation);
			
			return;
			//return load_map(stopLocations);
		}
		
	}
});

/*
function initialize_map()
{
    var myOptions = {
	      zoom: 4,
	      mapTypeControl: true,
	      mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
	      navigationControl: true,
	      navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
	      mapTypeId: google.maps.MapTypeId.ROADMAP      
	    }	
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
}

function initialize()
{
	var output = document.getElementById('current');
	
	if(navigator.geolocation)
	{
		output.innerHTML="Receiving...";
		navigator.geolocation.getCurrentPosition(show_position,function(){output.innerHTML="Couldn't get location"},{enableHighAccuracy:true});
	}
	else
	{
		output.innerHTML="Functionality not available";
	}
}

function show_position(position)
{

	if(typeof position == 'object'){
		if(!Object.keys(position).length){ // user
			var latitude = position.coords.latitude.toFixed(5),
				longitude = position.coords.longitude.toFixed(5),
				pinInfo = 'You are here';
		} else { // bus stops
			var latitude = position.Latitude,
				longitude = position.Longitude,
				pinInfo = 'Bus Stop: ' + position.Code + ' : ' + position.Name;
		}
	}
	
	
	var output = document.getElementById('current');
	
	output.innerHTML="latitude="+latitude+" longitude="+longitude;
	
	var pos=new google.maps.LatLng(latitude,longitude);
	map.setCenter(pos);
	map.setZoom(14);

	var infowindow = new google.maps.InfoWindow({
	    content: pinInfo
	});

	var marker = new google.maps.Marker({
	    position: pos,
	    map: map,
	    title:"Nearest Bus Stops"
	});

	google.maps.event.addListener(marker, 'click', function() {
	  infowindow.open(map,marker);
	});
	
}
*/
</script>
</body>
</html>
 