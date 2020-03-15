<?php
	include "connect.php";
	if(isset($_POST['dept_id'])){
		$dept_id = $_POST['dept_id'];
		$hydrant_lat = $_POST['hydrant_lat'];
		$hydrant_long = $_POST['hydrant_long'];
		$image_name = $_POST['image_name'];
		$sql = "SELECT * FROM users WHERE user_id = '$dept_id'";
		try{
			$result = mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
			$row = $result -> fetch_assoc();
			if($row['dept_id'] != 'citizen'){
				$sql1 = "INSERT INTO hydrants(dept_id, hydrant_lat, hydrant_long, image_name) VALUES('" . $row['dept_id'] . "', '$hydrant_lat', '$hydrant_long', '$image_name')";
				try{
					$result1 = mysqli_query($conn, $sql1) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
					echo "PLOT ADDED TO DATABASE!";
				}catch(Exception $e){
					echo "ERROR: " . $e;
				}
			}
			else{
				echo "You Are Not Authorized to Plot Hydrants";
			}
		}catch(Exception $e){
			echo "ERROR: " . $e;
		}
		// echo $_POST['hydrant_lat'];
		// echo $_POST['hydrant_long'];
	}
	else{
		echo "NO DATA!";
	}
?>