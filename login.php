<?php
	include "includes/connect.php";
    session_start();
	if(isset($_SESSION['user']['user_id'])){
        if(strval($_SESSION['user']['user_dept'])){
            header("Location: index.php");
        }
	}
?>


<!DOCTYPE html>
<html>
<head>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/particle.js"></script>
<link rel="stylesheet" type="text/css" href="css/login.css">
	<title>BFP LOGIN</title>
</head>
<body>
<div class="container">    
        
    <div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3"> 
        
        <div class="row">                
            <div class="iconmelon">
              <svg viewBox="0 0 32 32">
                <g filter="">
                  <use xlink:href="#git"></use>
                </g>
              </svg>
            </div>
        </div>
        
        <div class="panel panel-default" >
            <div class="panel-heading">
                <div class="panel-title text-center">BFP LOGIN</div>
                <?php 
                    if(isset($_SESSION['response'])){
                ?>
                <div class="alert alert-danger" role="alert">
                  <?php echo $_SESSION['response']; ?>
                </div>
                <?php
                        unset($_SESSION['response']);
                    } 
                ?>
            </div>     

            <div class="panel-body" >

                <form name="form" id="form" class="form-horizontal" enctype="multipart/form-data" method="POST" action="controller/login-controller.php">
                   
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="user" type="text" class="form-control" name="username" value="" placeholder="Username">                                        
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                    </div>                                                                  

                    <div class="form-group">
                        <!-- Button -->
                        <div class="col-sm-12 controls">
                            <button name="submit" value="submit" type="submit"class="btn btn-primary pull-right"><i class="glyphicon glyphicon-log-in"></i> Log in</button>                          
                        </div>
                    </div>

                </form>     

            </div>                     
        </div>  
    </div>
</div>

<div id="particles"></div>

</body>
</html>