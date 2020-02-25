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
  <img src="ordpresssample11.000webhostapp.com/mobile-server/uploads/temp/<?php echo $image_src; ?>" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title"><?php echo $image_location; ?></h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
  </div>
</div>

<?php

		}
	}


?>
