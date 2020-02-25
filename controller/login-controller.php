<?php
	include "../includes/connect.php";
	session_start();
	if(isset($_POST["submit"])){
		$username = $_POST["username"];
		$password = $_POST["password"];

		$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) == 1){
			$_SESSION['user'] = $result -> fetch_assoc();
			if($_SESSION['user']['dept_id'] != "citizen"){
				// echo $_SESSION['user']['dept_id'] . "if";
				exit(header("Location: ../index.php?location=dashboard"));
			}
			else{
				// echo $_SESSION['user']['dept_id'] . "else";
				$_SESSION['response'] = "Please Sign in to the mobile app";
				exit(header("Location: " . $_SERVER['HTTP_REFERER']));
			}
		}
		else{
			$_SESSION['response'] = "Username or Password is Incorrect";
			header("Location: " . $_SERVER['HTTP_REFERER']);
		}
	}
	else{
		echo "No data recieved";
	}



?>