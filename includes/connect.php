<?php



    header('Access-Control-Allow-Origin: *');
	$servername = "localhost";
	$username = "root";
	$password = "";
	$db = "bfp";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $db);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}



/////// for server
 //    header('Access-Control-Allow-Origin: *');
	// $servername = "localhost";
	// $username = "id7587232_bfpadmin";
	// $password = "admin1231";
	// $db = "id7587232_bfp";

	// // Create connection
	// $conn = new mysqli($servername, $username, $password, $db);

	// // Check connection
	// if ($conn->connect_error) {
	// 	die("Connection failed: " . $conn->connect_error);
5	// }
?>