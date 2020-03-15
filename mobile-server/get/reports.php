<br>
<br>
<br>
<br>
<br>

<?php
	include "../../includes/connect.php";

	if(isset($_POST['user_id'])){
		$user_id = $_POST['user_id'];
		$sql = "SELECT * FROM reports WHERE user_id = '$user_id'";
		$result = mysqli_query($conn, $sql);
		$counter = 0;
		// echo $user_id;
?>
<script type="text/javascript">
	var locations = [ 
<?php
		while($row = mysqli_fetch_assoc($result)){
			echo "{lat: parseFloat('" . $row['incident_lat'] . "'),lng: parseFloat('" . $row['incident_long'] . "')}";
			if(mysqli_num_rows($result)-1 > $counter){
				echo ",";
			}
			$counter += 1;
		}

?>
		];
</script>
<?php
	$counter = 0;
	$result = mysqli_query($conn, $sql);
	while($row = mysqli_fetch_assoc($result)){
		$image_src = "uploads/temp/" . $row["image_name"];
?>
<div class="card">
  <img src="http://wordpresssample11.000webhostapp.com/mobile-server/<?php echo $image_src; ?>" class="card-img-top" alt="...">
  <div class="card-body" id="body<?php echo $counter; ?>">
  	<input type="text" id="lat<?php echo $counter; ?>" value="<?php echo $row['incident_lat']; ?>" hidden>
  	<input type="text" id="lng<?php echo $counter; ?>" value="<?php echo $row['incident_long']; ?>" hidden>
    <h3 class="card-title"></h3>
  </div>
</div>
<br>

<?php
			$counter += 1;
		}
?>
<script type="text/javascript">
	var geocoder = new google.maps.Geocoder();
	function geocodeAddress(location, count){
		console.log(location);
		geocoder.geocode(
	      {'latlng': locations}, function getdata(results, status){
      	      if (status == google.maps.GeocoderStatus.OK) {
		              if (results[0]) {
		             		var incident_formatted_address = results[0].formatted_address;
		 					try{
								console.log(incident_formatted_address + " " + count);
								$("#body" + count + "").append("<p class='card-text'>"  + incident_formatted_address + "</p>");	
							}catch(e){
								console.log(e);
							}
		              }
		              else  {
		                  console.log("address not found");
		              }
		      }
		       else {
		          // alert("Geocoder failed due to: " + status);
		      }
	    });	
	}
	$(document).ready(function(){
		var counter = <?php echo $counter; ?>;
		var i = 0;
		// console.log(location[i].lat + " " + location[i].lng);
		for(i = 0; i < counter; i++){
			var latlng = new google.maps.LatLng(location[i].lat,location[i].lng);
			geocodeAddress(latlng, i);
		}
		
	});

</script>

<?php
	
	}
	else{
	    echo "error loading no data";	
	}


?>