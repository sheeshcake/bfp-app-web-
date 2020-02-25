<?php
//pinaka duol nga department
	include "connect.php";
	if(isset($_POST['calculate'])){
		$sql = "SELECT * FROM fire_departments";
		$result = mysqli_query($conn, $sql);
		$last_distance = 999999999;
		$dept_details;
		while($row = $result -> fetch_assoc()){
			// Calculate the nearby fire department
			$R = 6371; //earths radius in Km
			$dlat = deg2rad($row['dept_lat'] - $_POST['user_lat']);
			$dlong = deg2rad($row['dept_long'] - $_POST['user_long']);
			$a = sin($dlat/2) * sin($dlat/2) + cos(deg2rad($_POST['user_lat'])) * cos(deg2rad($row['dept_lat'])) * sin($dlong/2) * sin($dlong/2);
			$c = 2 * atan2(sqrt($a), sqrt(1-$a));
			$distance = $R * $c; //distance in KM
			if($distance < $last_distance){
				$last_distance = $distance;
				$dept_details['dept_id'] = $row['dept_id'];
				$dept_details['dept_name'] = $row['dept_name'];
				$dept_details['distance'] = $distance;
			}
			echo "distance: " . $distance;
		}
		echo json_encode($dept_details);
	}
	else if(isset($_POST['get'])){
		$sql = "SELECT * FROM fire_departments";
		$result = mysqli_query($conn, $sql);
		$counter = 0;
		while($row[$counter] = $result -> fetch_assoc()){
			$counter++;
		}
		echo json_encode($row);
	}

?>

