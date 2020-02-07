<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<title></title>
</head>
<body>
	<style type="text/css">
		body{
			background: rgb(48,48,48);
		}
		.card{
			margin: 2%;
		}
	</style>
<?php
	include "../includes/connect.php";

	if(isset($_GET['user_id'])){
		$user_id = $_GET['user_id'];
		$sql = "SELECT * FROM reports WHERE user_id = '$user_id'";
		$result = mysqli_query($conn, $sql);
		while($row = mysqli_fetch_assoc($result)){
		    //$_SERVER['DOCUMENT_ROOT'] . "/mobile-server/
			$image_src = "uploads/temp/" . $row["image_name"];
			$image_location = $row["incident_loc"];
			$file_out = $image_src; // The image to return

?>
<div class="card">
  <img src="<?php echo $image_src; ?>" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title"><?php echo $image_location; ?></h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
  </div>
</div>

<?php

		}
	}


?>
</body>
</html>
