<?php
  include "includes/connect.php";
  session_start();
  if(!isset($_SESSION['user'])){
    header("Location: login.php");
  }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
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
              <li class="nav-item <?php if($_GET['location'] == 'statistics') echo 'active'; ?>">
                <a class="nav-link" href="?location=statistics" tabindex="-1" aria-disabled="true" >Statistics</a>
              </li>
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
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Alert: New FIRE REPORT!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div id="data" class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
        <audio id="myAudio" muted hidden autoplay>
            <source id="source" src="audio/The-purge-siren.mp3" type="audio/mpeg">
        </audio>
    <script type="text/javascript">
      let rep_data;
      $('#close').click(function(){
          $.ajax({
            url: "controller/alert-controller.php",
            method:"POST",
            data: {'type':'seen', 'id': rep_data["report_id"]},
            success:function(data){
              console.log(data + "success!");
            }        
          });
      });
      /// mao ni ang realtime alert system nga code
      function check_reports(){
        $.ajax({
            url: "controller/alert-controller.php",
            method:"POST",
            data: {'type':'check'},
            success:function(data){
              try{
                  console.log(rep_data);
                  rep_data = JSON.parse(data);
                  $('#myModal').modal('show');
                  $('#data').html(rep_data["report_id"]);
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
      setInterval(function(){
          check_reports();
      },10000);
    </script>
</body>
</html>