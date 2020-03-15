<br>
<br>
<br>
<?php
	include "../connect.php";
	if(isset($_POST['u_reg_id'])){
		$u_reg_id = $_POST['u_reg_id'];
		$sql = "SELECT * FROM users INNER JOIN fire_departments ON fire_departments.dept_id=users.dept_id WHERE users.u_reg_id='$u_reg_id'";
		$result = mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($conn), E_USER_ERROR);
		$row = $result -> fetch_assoc();
		// echo $row['dept_lat'] . " " . $row['dept_long'];
?>

<br>
<div class="jumbotron">
	<div id="map_canvas" style="height: 100%;border-radius: 5px;padding-top: 100%;"></div>
	<div id="data">Loading Some Reports..</div>
</div>

<script type="text/javascript">
	var counter = 0;
	var directionsDisplay = new google.maps.DirectionsRenderer();
	var directionsService = new google.maps.DirectionsService();
	let map = new google.maps.Map(document.getElementById('map_canvas'), {
            zoomControl: false,
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: false,
            rotateControl: false,
            zoom: 26,
            mapTypeId: google.maps.MapTypeId.SATELLITE
    });
    let rep_incident_lat;
    let rep_incident_long;
    var done = false;
   //  function initMap(){
   //  	navigator.geolocation.getCurrentPosition(function(position){
			// map = new google.maps.Map(document.getElementById('map_canvas'), {
		 //            zoomControl: false,
		 //            mapTypeControl: false,
		 //            scaleControl: false,
		 //            streetViewControl: false,
		 //            rotateControl: false,
		 //            zoom: 26,
		 //            mapTypeId: google.maps.MapTypeId.SATELLITE
		 //    });
	  //       var marker = new google.maps.Marker({
	  //           position: point,
	  //           map: map,
	  //           title: "This is your Location"
	  //       });

			// marker.setMap(map);
   //  	});
   //  }
   //  initMap();
	function try_again(){
		if(done){
			navigator.geolocation.getCurrentPosition(track, onError , { maximumAge: 3000, timeout: 10000, enableHighAccuracy: true });
		}else{
			navigator.geolocation.getCurrentPosition(onSuccess, onError , { maximumAge: 3000, timeout: 10000, enableHighAccuracy: true });
		}
	}
	function onSuccess(position){
    	if(!done){
	    	console.log("Your position: " + position.coords.latitude + " - " + position.coords.longitude);
			// console.log("Incident position: " + rep_data.incident_lat + " - " + rep_data.incident_long);
			const c = <?php echo $row['dept_id']; ?>;
			console.log(c);
			$.ajax({
	            url: "http://wordpresssample11.000webhostapp.com/mobile-server/dashboard_alerts.php",
	            method:"POST",
	            data: {
	              'type':'check',
	              'id': c,
	              'user_lat': position.coords.latitude,
	              'user_long': position.coords.longitude
	            },
	            success:function(data){
	            	console.log(data);
	              try{
						console.log(data);
						counter++;
						var rep_data = JSON.parse(data);
						rep_incident_lat = rep_data.incident_lat;
						rep_incident_long = rep_data.incident_lat;
						$("#data").html("");
						$("#data").append("<center><p>Location: lat" + rep_data.incident_lat + ", long: " + rep_data.incident_long + 
							"</p><p>Your Location: lat: " + 
							position.coords.latitude + ", long: " +
							position.coords.longitude + 
						 	"</center>");
				        var incident_LatLng = new google.maps.LatLng(rep_data.incident_lat, rep_data.incident_long);
				        var hydrant_LatLng = new google.maps.LatLng(rep_data.hydrant_lat, rep_data.hydrant_long);
		                var incident_marker = new google.maps.Marker({
							position: incident_LatLng,
							map: map,
							icon: "http://wordpresssample11.000webhostapp.com/images/fire.gif",
							optimized: false
			         	});
			         	var hydrant_marker = new google.maps.Marker({
			         		position: hydrant_LatLng,
			         		map: map,
			         		icon:"http://wordpresssample11.000webhostapp.com/images/hydrant.png"	
			         	});
						var point = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				        var marker = new google.maps.Marker({
				            position: point,
				            map: map,
				            title: "This is your Location"
				        });
				        map.panTo(point);
	         	        // var bounds = new google.maps.LatLngBounds();
				        // bounds.extend(point);
				        // bounds.extend(incident_LatLng);
				        // bounds.extend(hydrant_LatLng);
				        incident_marker.setMap(map);
				        hydrant_marker.setMap(map);
				        marker.setMap(map);
				        // map.fitBounds(bounds);
			    		var start = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			    		var end = new google.maps.LatLng(rep_data.incident_lat, rep_data.incident_long);
						var request = {
							origin: start, //<?php //echo "[" . $dept_data['dept_lat'] . "," . $dept_data['dept_long'] . "]"; ?> ,
							destination: end, //[parseFloat(rep_data.incident_lat), parseFloat(rep_data.incident_long)],
							travelMode: google.maps.TravelMode.DRIVING
						};
						directionsService.route(request, function (response, status) {
							if (status == google.maps.DirectionsStatus.OK) {
								directionsDisplay.setDirections(response);
								directionsDisplay.setMap(map);
								done = true;
								try_again();
							} else {
								console.log("Directions Request from " + myLocation + " to " + incident_LatLng + " failed: " + status);
							}
						});
	                }
	                catch(e){
	                  $("#data").html("");
	                  $("#data").append("<center><p>No Reports</p></center>");
	                  console.log(e + "dept id: " + c);
	                  try_again();
	                }
	            },
	            error:function(data){
	              console.log("error: " + rep_data);
	            }
	        });
    	}
    }
	function onError(error){
		console.log(error.code + " - " + error.message + "\nTrying again.");
		try_again();
	}
	function track(position){
		console.log("tracking");
		console.log("Your position: " + position.coords.latitude + " - " + position.coords.longitude);
		console.log("Incident position: " + rep_incident_lat + " - " + rep_incident_long);
		$("#data").html("");
		$("#data").append("<center><p>Location: lat" + rep_incident_lat + ", long: " + rep_incident_long + 
			"</p><p>Your Location: lat: " + 
			position.coords.latitude + ", long: " +
			position.coords.longitude + 
		 	"</center>");
		var start = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		var end = new google.maps.LatLng(rep_incident_lat, rep_incident_long);
		var request = {
			origin: start, //<?php //echo "[" . $dept_data['dept_lat'] . "," . $dept_data['dept_long'] . "]"; ?> ,
			destination: end, //[parseFloat(rep_data.incident_lat), parseFloat(rep_data.incident_long)],
			travelMode: google.maps.TravelMode.DRIVING
		};
		var point = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        var marker = new google.maps.Marker({
            position: point,
            map: map,
            title: "This is your Location"
        });
		directionsService.route(request, function (response, status) {
			if (status == google.maps.DirectionsStatus.OK) {
				directionsDisplay.setDirections(response);
				directionsDisplay.setMap(map);
				try_again();
			} else {
				console.log("Directions Request from " + start + " to " + end + " failed: " + status + "\nTrying again..");
				try_again();
			}
		});
	}
	try_again();
</script>
<?php
	}
?>