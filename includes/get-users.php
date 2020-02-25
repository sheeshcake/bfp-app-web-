<br>
<br>
<br>
<br>
<div id="dash_map"></div>
<?php
	$sql = "SELECT * FROM user_registration INNER JOIN users ON users.u_reg_id=user_registration.u_reg_id WHERE user_registration.is_confirmed = 'false'";
	$result = mysqli_query($conn, $sql);
	while($row = $result -> fetch_assoc()){

?>
<div class="card">
  <img src="http://wordpresssample11.000webhostapp.com/mobile-server/uploads/users/<?php echo $row['valid_id']; ?>" class="card-img-top" alt="...">
  <div class="card-body" >
  	<input type="text" value="<?php echo $row['u_reg_id']; ?>" hidden>
    <h3 class="card-title"><?php echo $row['first_name'] . " " . $row['last_name']; ?></h3>
    <h5 class="card-title">Gender: <?php echo $row['gender']; ?></h5>
    <h5 class="card-title">Address: <?php echo $row['address']; ?></h5>
    <button class="btn confirm btn-primary" type="button" value="<?php echo $row['u_reg_id']?>">Confirm</button>
  </div>
</div>
<br>

<?php
	}

?>
<script type="text/javascript">
	$(".confirm").click(function(){
		var id = $(this).val();
		// alert(id);
		$.ajax({
			url: "controller/confirm-controller.php",
			method: "POST",
			data: {'id' : id},
			success: function(response){
				alert(response);
				location.reload();
			}
		});
	});
</script>