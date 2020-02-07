<?php
	include "connect.php";
	if(isset($_POST['username']) && isset($_POST["password"])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$sql = "SELECT * FROM users WHERE username ='$username' AND password = '$password'";
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result) == 1){
			$row = mysqli_fetch_assoc($result);
			echo json_encode($row);
		}
		else{
			echo "ERROR!!!";
		}
	}
	else{
		echo "error";
	}

?>