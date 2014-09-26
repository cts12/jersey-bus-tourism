<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Hackathon</title>
</head>
<body>
<div id="out">

</div>


<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
$()function(){
	geofindMe();
};

function geoFindMe() {
  var output = document.getElementById("out");

  if (!navigator.geolocation){
    output.innerHTML = "<p>Geolocation is not supported by your browser</p>";
    return;
  }

  function success(position) {
    var latitude  = position.coords.latitude;
    var longitude = position.coords.longitude;

    output.innerHTML = '<p>Latitude is ' + latitude + '° <br>Longitude is ' + longitude + '°</p>';

    var img = new Image();
    img.src = "http://maps.googleapis.com/maps/api/staticmap?center=" + latitude + "," + longitude + "&zoom=13&size=300x300&sensor=false";

    output.appendChild(img);
  };

  function error() {
    output.innerHTML = "Unable to retrieve your location";
  };

  output.innerHTML = "<p>Locating…</p>";

  navigator.geolocation.getCurrentPosition(success, error);
}
</script>
<?php /*
<script type="text/javascript" src="/assets/js/geoPosition.js" charset="utf-8"></script>
<script type="text/javascript">
    if(geoPosition.init()){  // Geolocation Initialisation
        geoPosition.getCurrentPosition(success_callback,error_callback,{enableHighAccuracy:true});
    }else{
        // You cannot use Geolocation in this device
		alert('You cannot use Geolocation in this device');
    }
    // geoPositionSimulator.init(); 

    // p : geolocation object
    function success_callback(p){
		console.log(p);
		$('body').html(p.coords.latitude + ' ' + p.coords.longitude);
    }

    function error_callback(p){
        // p.message : error message
    }
</script>
*/
?>
</body>
</html>
 