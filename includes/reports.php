<br><br><br>
<input id="dept_id" name="id" value="<?php echo $_SESSION['user']['dept_id']; ?>" hidden>
<input id="user_id" name="id" value="<?php echo $_SESSION['user']['user_id']; ?>" hidden>
<h1>THis is Reports</h1>

<?php
	// include "../includes/connect.php";
	$sql = "SELECT * FROM reports";
	$result = mysqli_query($conn, $sql);
	while($row = $result -> fetch_assoc()){
?>
<div class="jumbotron">
	<img src="../mobile-server/uploads/temp/<?php echo $row['image_name'] ?>" style="width: 300px;">
	<p><?php echo "Date and Time: " . $row['date_upload'] . " at " . $row['time_upload'] . ""; ?></p>
	<center>
		<p><?php echo "Lat: " . $row['incident_lat'] . ""; ?></p>
		<p><?php echo "Long: " . $row['incident_long'] . ""; ?></p>
	</center>
	<?php
		$sql1 = "SELECT * FROM fire_departments WHERE dept_id = '" . $row['dept_id'] . "'";
		$result1 = mysqli_query($conn, $sql1);
		$fire_row = $result1 -> fetch_assoc();
	?>
	<p>Incident Reported to: <?php echo  $fire_row['dept_name']; ?></p>
</div>
<?php

	}
?>