<?php
    include "connect.php";
    if(isset($_POST['user_id'])){
        $image_name = $_POST['file_id'];
        $user_id = $_POST['user_id'];
        $incident_lat = $_POST['incident_lat'];
        $incident_long = $_POST['incident_long'];
        $dept_id = $_POST['dept_id'];
        // echo $incident_loc;
        // echo "IMAGE LOCATION" . $image_loc;
        // $dir = str_replace("public_html","tmp",$_SERVER['DOCUMENT_ROOT']) . '/uploads/' . $user_id . '/';
        // $dir = $_SERVER['DOCUMENT_ROOT'] . "/mobile-server/uploads/temp/";
        // echo $dir;
        // if (is_dir($dir)){
            // echo "dir is present";
        // }
        // else{
            // mkdir ($dir, 0755);
        // }
        // $location = str_replace("public_html","tmp",$_SERVER['DOCUMENT_ROOT']) . '/uploads/temp/'. $image_name;
        // $location = '/uploads/temp/'. $image_name;
        // $destination = $dir . $image_name;
        // chmod($location, 755);
        // echo $image_name . "--" . $location;
        try {
            try{
                // rename((string)$location, (string)$dir . (string)$image_name);
                //chmod((string)$dir . (string)$image_name), 755);

                $date = date("m/d/Y");
                $time = date("h:i:sa");
                $sql = "INSERT INTO reports(user_id,dept_id,image_name,incident_lat,incident_long,image_desc,date_upload,time_upload)" .
                        "values('$user_id','$dept_id','$image_name','$incident_lat','$incident_long','none','$date', '$time')";
                try{
                    $result = mysqli_query($conn, $sql);
                    echo "Incident Reported!";
                }catch(Exception $e){
                    echo "ERROR!" . $e;
                }
            }
            catch(Exception $e){
                echo "Error on File Sync. " + $e;
            }

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        // if(){
        //     $date = date("m/d/Y");
        //     $time = date("h:i:sa");
        //     $sql = "INSERT INTO reports(user_id,image_name,incident_loc,image_desc,date_upload,time_upload)" .
        //             "values('$user_id','$image_name','','','$date', '$time')";
        //     if($result = mysqli_query($conn, $sql)){
        //         echo "Incident Reported!";
        //     }
        // }
        // else{
        //     echo "ERROR in Synchorize";
        // }
        // if ( $_FILES['file']['error'] > 0 ){
        //     echo 'Error: ' . $_FILES['file']['error'] . '<br>';
        // }
        // else {
        //     if(move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $user_id . '/' . $_FILES['file']['name']))
        //     {
        //         $image_name = $_FILES['file']['name'];
        //         $date = date("m/d/Y");
        //         $time = date("h:i:sa");
        //         $sql = "INSERT INTO reports(user_id,image_name,incident_loc,image_desc,date_upload,time_upload)" .
        //                 "values('$user_id','$image_name','','','$date', '$time')";
        //         if($result = mysqli_query($conn, $sql)){
        //             echo "Incident Reported!";
        //         }
        //     }
        // }
    }

?>

