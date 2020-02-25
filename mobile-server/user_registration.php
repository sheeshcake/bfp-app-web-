<?php
	include "connect.php";
	if(isset($_POST["f_name"])){
		$f_name = $_POST["f_name"];
		$l_name = $_POST["l_name"];
		$address = $_POST["address"];
		$gender = $_POST["gender"];
		$username = $_POST["username"];
		$password = $_POST["password"];
	    $new_image_name = urldecode($_FILES["val-id"]["name"]);
    	move_uploaded_file($_FILES["val-id"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/mobile-server/uploads/users/" . $new_image_name);
    	$sql = "INSERT INTO user_registration(first_name, last_name, valid_id, address, gender) VALUES('$f_name' , '$l_name', '$new_image_name', '$address', '$gender')";
    	// echo $f_name . " " . $l_name . " " . $new_image_name;
    	if ($conn->query($sql) === TRUE) {
	    	$last_id = $conn->insert_id;
	    	// echo "New record created successfully. Last inserted ID is: " . $last_id;
	    	$sql1 = "INSERT INTO users(user_id, u_reg_id, username, password) VALUES('$last_id', '$last_id', '$username', '$password')";
	    	if($conn->query($sql1) === TRUE){
	    		echo "Registration Added, Waiting for Confirmation";
	    	}
	    	else{
	    		echo "Error: " . $sql1 . "<br>" . $conn->error;
	    	}
		} else {
	    	echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	else{
		echo "No data";
	}

?>