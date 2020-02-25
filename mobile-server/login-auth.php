<?php
	include "connect.php";
	if(isset($_POST['username']) && isset($_POST["password"])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$sql = "SELECT * FROM users WHERE username ='$username' AND password = '$password'";
		$result = mysqli_query($conn,$sql);
		$row = $result -> fetch_assoc();
		if($row['role'] == 'admin'/*change this as citizen in the future please*/){
			$id = $row['u_reg_id'];
			$sql2 = "SELECT * FROM user_registration INNER JOIN users ON users.u_reg_id=user_registration.u_reg_id WHERE users.u_reg_id = '$id'";
			$result2 = mysqli_query($conn, $sql2);
			if(mysqli_num_rows($result2) == 1){
				$row2 = $result2 -> fetch_assoc();
				echo json_encode($row2);
			}
			else{
				echo "ERROR!!!";
			}
		}
		else if($row['role'] == "citizen"){
			$id = $row['u_reg_id'];
			$sql2 = "SELECT * FROM user_registration INNER JOIN users ON users.u_reg_id=user_registration.u_reg_id WHERE users.u_reg_id = '$id'";
			$result2 = mysqli_query($conn, $sql2);
			if(mysqli_num_rows($result2) == 1){
				$row2 = $result2 -> fetch_assoc();
				if($row2["is_confirmed"] == 'true'){
					echo json_encode($row2);
				}
				else{
					echo "Your account is on confirmation";
				}
			}
			else{
				echo "ERROR!!!";
			}
		}
	}
	else{
		echo "error";
	}

?>