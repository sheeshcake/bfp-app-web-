<?php
    include "../includes/connect.php";
    if(isset($_POST['type'])){
        if($_POST['type'] == "check"){
            $sql = "SELECT * FROM hydrants";
            $result = mysqli_query($conn, $sql);
            $last_distance = 999999999;
            $hydrant_details;
            while($row = $result -> fetch_assoc()){
                // Calculate the nearby fire hydrants
                $R = 6371; //earths radius in Km
                $dlat = deg2rad($row['hydrant_lat'] - $_POST['user_lat']); //distance sa lat
                $dlong = deg2rad($row['hydrant_long'] - $_POST['user_long']);//distance sa lonh
                $a = sin($dlat/2) * sin($dlat/2) + cos(deg2rad($_POST['user_lat'])) * cos(deg2rad($row['hydrant_lat'])) * sin($dlong/2) * sin($dlong/2); 
                $c = 2 * atan2(sqrt($a), sqrt(1-$a));
                $distance = $R * $c; //distance in KM
                if($distance < $last_distance){
                    $last_distance = $distance;
                    $hydrant_details['hydrant_id'] = $row['hydrant_id'];
                    $hydrant_details['distance'] = $distance;
                }
            }
            $dept_id = $_POST['id'];
            $sql = "SELECT * FROM reports WHERE reports.is_seen = 'false' AND reports.dept_id='$dept_id'";//inner join para ma kuha ang location sa hydrant ug sa report
            $sql1 = "SELECT * FROM hydrants WHERE hydrant_id=" . $hydrant_details['hydrant_id'] . "'";
            $result = mysqli_query($conn, $sql);
            $result1 = mysqli_query($conn, $sql1);
            $data['report'] = $result->fetch_assoc();
            $data['hydrants'] = $result1->fetch_assoc();
            if(mysqli_num_rows($result) > 0){
                echo $dept_id;
                echo json_encode($data);
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