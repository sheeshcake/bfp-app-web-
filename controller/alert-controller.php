<?php
    include "../includes/connect.php";
    if(isset($_POST['type'])){
        if($_POST['type'] == "check"){
            $dept_id = $_POST['id'];
            $sql = "SELECT * FROM reports INNER JOIN user_registration ON reports.user_id=user_registration.u_reg_id WHERE is_seen = 'false' AND dept_id='$dept_id'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0){
                echo json_encode($result->fetch_assoc());
            }
            else{
                echo "no data";
            }
        }
        else if($_POST['type'] == "seen"){
            $id = $_POST['id'];
            $sql1 = "UPDATE reports SET is_seen = 'true' WHERE report_id='$id'";
            $result1 = mysqli_query($conn, $sql1);   
        }
    }
?>