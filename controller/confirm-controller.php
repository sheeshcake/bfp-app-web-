<?php
	include "../includes/connect.php";
	if(isset($_POST["id"])){
		$id = $_POST["id"];
		$sql = "UPDATE user_registration SET is_confirmed='true' WHERE u_reg_id = '$id'";
		if($result = mysqli_query($conn, $sql)){
			echo "User Confirmed!";
		}
		else{
			echo "ERROR";
		}
	}
	else{
		echo "No Data";
	}
?>