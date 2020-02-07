<?php
	include "connect.php";
	echo "hello<br>";
	if(isset($_GET['file'])){
		$file =  $_SERVER['DOCUMENT_ROOT'] . "/mobile-server/uploads/1/" . $_GET['file'];
		if(chmod($file, 755)){
			echo "success!";
			echo $_SERVER['DOCUMENT_ROOT'];
			echo str_replace("public_html","tmp",$_SERVER['DOCUMENT_ROOT']);
			$img = "uploads/1/" . $_GET['file'];
?>
	<img src="<?php echo $img; ?>">
<?php
		}
		else{
			echo "error!";
		}
	}
	else{
		echo "cant get the file value";
	}
?>