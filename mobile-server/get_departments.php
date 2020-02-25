<?php
	include "connect.php";
	if(isset($_POST['dept_id'])){
		$dept_id = $_POST['dept_id'];
		$sql = "SELECT * FROM fire_departments WHERE dept_id = '$dept_id'";
		$result = mysqli_query($conn, $sql);
		$row = $result -> fetch_assoc();
		echo json_encode($row);
	}


?>