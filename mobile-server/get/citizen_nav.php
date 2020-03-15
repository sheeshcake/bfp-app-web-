  <li class="nav-item active">
    <a class="nav-link" id="home" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" data-toggle="collapse" >Home <span class="sr-only">(current)</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="getreports" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" data-toggle="collapse" >Your Reports</a>
  </li>
  <li class="nav-item">
    <a class="nav-link disabled" href="#" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" tabindex="-1" aria-disabled="true" data-toggle="collapse" >Instructions</a>
  </li>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
    <div class="dropdown-menu" aria-labelledby="dropdown01">
      <a class="dropdown-item" href="#" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" data-toggle="collapse" id="view_profile">View Profile</a>
      <a id="logout" class="dropdown-item" href="#" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault">Logout</a>
    </div>
  </li>
  <script type="text/javascript">
    $("#logout").click(function(){
      $("#loading").show();
      $.ajax({
          url: "http://wordpresssample11.000webhostapp.com/mobile-server/get/login.php",
          method: "GET",  
          success: function(data){
              // console.log(data);
              document.getElementById("navigation").style.display = "none";
              $("#loading").hide();
              $("#container").html(data);
          }
      });
  });
  $("#view_profile").click(function(){
      $("#loading").show();
      $.ajax({
          url: "http://wordpresssample11.000webhostapp.com/mobile-server/get/profile.php",
          method: "POST", 
          data: {'user_id' : $("#u_reg_id").val()},
          success: function(data){
              // console.log(data);
              $("#loading").hide();
              $("#container").html(data);
          }
      });
  });
  $("#getreports").click(function(){
      console.log($("#user_id").val());
      $("#loading").show();
      $.ajax({
          url: "http://wordpresssample11.000webhostapp.com/mobile-server/get/reports.php",
          method: "POST",
          data:{'user_id' : $("#u_reg_id").val()},
          success: function(data){
              // console.log(data);
              $("#loading").hide();
              $("#container").html(data);
          }
      });
  });

  $("#home").click(function(){
        $("#loading").show();
        $.ajax({
            url: "http://wordpresssample11.000webhostapp.com/mobile-server/get/" + $("#role").val() + ".php",
            method: "GET",
            success: function(data){
                // console.log(data);
                console.log($("#u_reg_id").val());
                $("#loading").hide();
                $("#container").html(data);
            }
        });
    });
  </script>