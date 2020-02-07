<?php
	include "connect.php";
    $date = date("m/d/Y");
    $handshake_data = $_POST['handshake_data'];
	if($_POST['handshake_data'] == $date . "handshake"){
		// echo $_POST['handshake_data'] . "===" .$date . "handshake and true";
		echo "true";
	}
	else{
		// echo $_POST['handshake_data'] . "===" .$date . "handshake and false";
		echo "false";
	}

?>