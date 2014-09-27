<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Hackathon Buses</title>
</head>
<body>

	<div id="current">Initializing...</div>
	<div id="map_canvas" style="width:100%; height:500px"></div>
	<div id="json"></div>
	
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//code.google.com/apis/gears/gears_init.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
initialize_map();
initialize();

$(function(){
	$.ajax({ 
		type: 'GET', 
		url: 'bus-stops.json', 
		dataType:'json',
		beforeSend:function(){},
		success: function (data) { 
			//console.log(data);
			
			var count = 0,
				latitude = '',
				longitude = '';
			$(data).each(function(i,val){
				//if(count < 20){
					$.each(val,function(k,v){
						if(k == 'Latitude'){
							latitude = v;
						}
						
						if(k == 'Longitude'){
							longitude = v;
							++count;
						}
						
						if(longitude.length){
							show_position('',latitude,longitude);
							
							latitude = '';
							longitude = '';
						}
					})
				//}
			});
		},
		error: function(data){
			console.log('Error: ' + data);
		}
	});
});

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

function show_position(p,latitude,longitude)
{
	if(typeof p == 'object'){
		latitude = p.coords.latitude.toFixed(5);
		longitude = p.coords.longitude.toFixed(5);
	}
	
	console.log(latitude);
	
	var output = document.getElementById('current');
	
	output.innerHTML="latitude="+latitude+" longitude="+longitude;
	
	var pos=new google.maps.LatLng(latitude,longitude);
	map.setCenter(pos);
	map.setZoom(14);

	var infowindow = new google.maps.InfoWindow({
	    content: "<strong>yes</strong>"
	});

	var marker = new google.maps.Marker({
	    position: pos,
	    map: map,
	    title:"You are here"
	});

	google.maps.event.addListener(marker, 'click', function() {
	  infowindow.open(map,marker);
	});
	
}
</script>
</body>
</html>
 