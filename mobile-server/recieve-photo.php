<?php
	include "connect.php";

    $new_image_name = urldecode($_FILES["file"]["name"]);
    // move_uploaded_file($_FILES["file"]["tmp_name"], str_replace("public_html","tmp",$_SERVER['DOCUMENT_ROOT']) . "/uploads/temp/".$new_image_name);
    move_uploaded_file($_FILES["file"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/mobile-server/uploads/temp/" . $new_image_name);
    echo $new_image_name;

?>