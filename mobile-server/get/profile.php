<br>
<br>
<br>
<br>
<br>
<br>
<div class="jumbotron">
<?php
	include "../connect.php";
	if(isset($_POST['user_id'])){
		$sql = "SELECT * FROM user_registration INNER JOIN users ON users.u_reg_id=user_registration.u_reg_id WHERE user_registration.u_reg_id = '" . $_POST['user_id'] . "'";
		try{
			$result = mysqli_query($conn, $sql);
			$row = $result -> fetch_assoc();
?>
	<img class="card-img-top" src="http://wordpresssample11.000webhostapp.com/mobile-server/uploads/users/<?php echo $row['valid_id']; ?>">
	<h1><?php echo $row['first_name'] . " " . $row['last_name']; ?></h1>
	<h5><?php echo $row['gender']; ?></h5>
	<h5><?php echo $row['address']; ?></h5>
<?php
		}catch(Exception $e){
			echo "ERROR!: " . $e;
		}
	}

?>


</div>