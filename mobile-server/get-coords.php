<?php

	if(isset($_POST['user_id'])){
		$user_id = $_POST['user_id'];
		$sql = "SELECT incident_lat, incident_long FROM reports WHERE user_id = '$user_id'";
		$result = mysqli_query($conn, $sql);
		$counter = 0;
	}
?>