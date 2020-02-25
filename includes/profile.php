<br><br><br>
<input id="dept_id" name="id" value="<?php echo $_SESSION['user']['dept_id']; ?>" hidden>
<input id="user_id" name="id" value="<?php echo $_SESSION['user']['user_id']; ?>" hidden>
<h1>THis is Profile</h1>
<?php
	// include "includes/connect.php";
	$id = $_SESSION['user']['user_id'];
	$sql = "SELECT * FROM users INNER JOIN user_registration ON users.u_reg_id = user_registration.u_reg_id WHERE users.user_id = '$id'";
	$result = mysqli_query($conn, $sql);
	$row = $result -> fetch_assoc();
?>
<div class="jumbotron">
	<div class="input-group">
	    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
	    <input id="f_name" type="text" class="form-control" name="first_name" value="<?php echo $row['first_name']; ?>" placeholder="Fisrt Name">                                        
	</div>
	<div class="input-group">
	    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
	    <input id="l_name" type="text" class="form-control" name="last_name" value="<?php echo $row['last_name']; ?>" placeholder="Lasr Name">                                        
	</div>
	<div class="input-group">
	    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
	    <input id="username" type="text" class="form-control" name="username" value="<?php echo $row['username']; ?>" placeholder="Username">                                        
	</div>
	<div class="input-group">
	    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
	    <input id="password" type="password" class="form-control" name="password" value="<?php echo $row['password']; ?>" placeholder="Password">                                        
	</div>
</div>
<?php

?>