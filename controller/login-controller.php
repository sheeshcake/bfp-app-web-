<?php
	include "../includes/connect.php";
	session_start();
	if(isset($_POST["submit"])){
		$username = $_POST["username"];
		$password = $_POST["password"];

		$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) == 1){

			$_SESSION["user"] = "Loggedin";
			header("Location: ../index.php");
		}
		else{
			echo "ERROR!";
		}
	}
	else{
		echo "No data recieved";
	}



?>