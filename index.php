<?php
  include "includes/connect.php";
  session_start();
  // echo $_SESSION['user']['user_id'];
  if(isset($_SESSION['user'])){
    $dept_id = $_SESSION['user']['dept_id'];
    $sql = "SELECT * FROM fire_departments WHERE dept_id='$dept_id'";
    $result = mysqli_query($conn, $sql);
    $dept_data = $result -> fetch_assoc();
  }else{
    header("Location: login.php");
  }
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
    <script type="text/javascript">
      
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBfNafBUY8TVgLcPMCPISzgEVnSSEIU1XQ&callback=initMap"></script>
    <script async defer type="text/javascript" src="https://www.googleapis.com/geolocation/v1/geolocate?key=AIzaSyBfNafBUY8TVgLcPMCPISzgEVnSSEIU1XQ"></script>
    <link rel="shortcut icon" href="">
    <!-- <script type="text/javascript" src="js/alert.js"></script> -->
  <title>BFP Admin</title>
</head>
<body>
    <div id="home" style="">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
          <a class="navbar-brand" href="#">BFP</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item <?php if($_GET['location'] == 'dashboard') echo 'active'; ?>">
                <a class="nav-link" href="?location=dashboard">Dashboard</a>
              </li>
              <li class="nav-item <?php if($_GET['location'] == 'reports') echo 'active'; ?>">
                <a class="nav-link" href="?location=reports" id="getreports">Reports</a>
              </li>
              <li class="nav-item <?php if($_GET['location'] == 'get-users') echo 'active'; ?>">
                <a class="nav-link" href="?location=get-users" tabindex="-1" aria-disabled="true" >Users</a>
              </li>
              <?php if($_SESSION['user']['role'] == 'admin'){
              ?>
              <li class="nav-item <?php if($_GET['location'] == 'register') echo 'active'; ?>">
                <a class='nav-link' href='?location=register'>Register New STAFF?</a>
              </li>
              <?php
                  }
              ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                  <a class="dropdown-item" href="?location=profile">View Profile</a>
                  <a class="dropdown-item" href="controller/logout.php">Logout</a>
                </div>
              </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
              <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
              <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
            </form>
          </div>
        </nav>
        <main role="main" class="container">
        <?php
          if(isset($_GET["location"])){
            if(file_exists("includes/" . $_GET["location"] . ".php")){
              include "includes/" . $_GET["location"] . ".php";
            }
            else{
              include "includes/error404.php";
            }
          }
          else{
            $_GET["location"] = "dashboard";
            include "includes/dashboard.php";
          }
        ?>
        </main>
    </div>
    <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Alert: New FIRE REPORT!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div id="data" class="modal-body">
        <audio id="myAudio" autoplay loop muted>
            <source id="source" src="audio/The-purge-siren.mp3" type="audio/mpeg">
        </audio>
        <div>
        </div>
        <div class="card" id="map" style="height: 400px;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
    <script type="text/javascript">
      ////////////////////// NOTE TO SELF ///////////////////////////
      /// PLEASE MOVE THIS TO ANOTHER FILE
      let rep_data;
      let counter = 0;
      let incident_formatted_address = "none";
      let directionsDisplay;
      let map;


      $('#close').click(function(){
        counter = 0;
          $.ajax({
            url: "controller/alert-controller.php",
            method:"POST",
            data: {
              'type':'seen', 
              'id': rep_data["report_id"]
            },
            success:function(data){
              var audio = document.getElementById("myAudio");
              audio.muted = true;
              audio.play();
              console.log(data + "success!");
            }        
          });
      });
      /// mao ni ang realtime alert system nga code
      function check_reports(){
        const c = $("#dept_id").val();
        console.log(counter);
        $.ajax({
            url: "controller/alert-controller.php",
            method:"POST",
            data: {
              'type':'check', 
              'id': c
            },
            success:function(data){
              try{
                  console.log(rep_data);
                  rep_data = JSON.parse(data);
                  $('#myModal').modal('show');
                  // $('#data').html();
                  add_map(rep_data);
                }
                catch(e){
                  console.log("no false: " + rep_data);
                }
            },
            error:function(data){
              console.log("error: " + rep_data);
            }
        });

      }

      //realtime loop
      setInterval(function(){
        if(counter < 2){
          check_reports();
        }
      }, 10000 /// Making this as 10 seconds
      );

      /// initialize map for dashboard
      function initMap(){
        var myLatLng = <?php echo "{lat: " . $dept_data['dept_lat'] . ", lng:" . $dept_data['dept_long'] . "}"; ?>;/// change this after testing: DONE
        var map = new google.maps.Map(document.getElementById('dash_map'), {
            zoom: 26,
            mapTypeId: 'satellite',
            center: myLatLng
        });
        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: 'Hello World!'
        });
        var geocoder;
        geocoder = new google.maps.Geocoder();
        geocoder.geocode(
          {'latLng': myLatLng}, 
          function(results, status) {
              if (status == google.maps.GeocoderStatus.OK) {
                      if (results[0]) {
                          console.log(results[0].formatted_address);
                      }
                      else  {
                          console.log("address not found");
                      }
              }
               else {
                  alert("Geocoder failed due to: " + status);
              }
          }
        );
      }


      function add_map(data) {
        directionsDisplay = new google.maps.DirectionsRenderer();
        let directionsService = new google.maps.DirectionsService();
        counter++;
        var audio = document.getElementById("myAudio");
        audio.muted = false;
        audio.play();
        console.log("opening modal");
        console.log(rep_data.incident_lat);
        var incident_LatLng = {lat:parseFloat(rep_data.incident_lat), lng: parseFloat(rep_data.incident_long)};
        var map = new google.maps.Map(document.getElementById('map'), {
          mapTypeId: 'satellite',
          center: incident_LatLng});
        var myLocation = <?php echo "{lat: " . $dept_data['dept_lat'] . ", lng:" . $dept_data['dept_long'] . "}"; ?>;/// change this after testing : DONE
        var bounds = new google.maps.LatLngBounds();
        bounds.extend(myLocation);
        bounds.extend(incident_LatLng);
        map.fitBounds(bounds);


        //fire marker
        var incident_marker = new google.maps.Marker({
          position: incident_LatLng,
          map: map,
          icon: "images/fire.gif",
          optimized: false
         });
        var geocoder;
        // var incident_formatted_address = "";
        geocoder = new google.maps.Geocoder();
        geocoder.geocode(
          {'latLng': incident_LatLng}, 
          function(results, status) {
              if (status == google.maps.GeocoderStatus.OK) {
                      if (results[0]) {
                          console.log(incident_formatted_address);
                          console.log(results[0].formatted_address);
                          incident_formatted_address = results[0].formatted_address;
                          console.log(incident_formatted_address);
                      }
                      else  {
                          console.log("address not found");
                      }
              }
               else {
                  alert("Geocoder failed due to: " + status);
              }
          }
        );
        console.log(incident_formatted_address);
        var contentString = '<div><p style="color: black">' + incident_formatted_address + '</p>' + '<img style="width: 300px" src="mobile-server/uploads/temp/' + data.image_name + '"></div>';
        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });
        infowindow.open(map, incident_marker);
        var marker = new google.maps.Marker({position: myLocation, map: map});
        try{
          var request = {
              origin: myLocation, //<?php //echo "[" . $dept_data['dept_lat'] . "," . $dept_data['dept_long'] . "]"; ?> ,
              destination: incident_LatLng, //[parseFloat(rep_data.incident_lat), parseFloat(rep_data.incident_long)],
              travelMode: google.maps.TravelMode.DRIVING
          };
          directionsService.route(request, function (response, status) {
              if (status == google.maps.DirectionsStatus.OK) {
                  directionsDisplay.setDirections(response);
                  directionsDisplay.setMap(map);
              } else {
                  alert("Directions Request from " + myLocation + " to " + incident_LatLng + " failed: " + status);
              }
          });
        }catch(e){
          console.log(e);
        }
      }
    </script>
</body>
</html>