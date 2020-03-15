<li class="nav-item active">
  <a class="nav-link" id="home" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" data-toggle="collapse" href="#">Dashboard <span class="sr-only">(current)</span></a>
</li>
<li class="nav-item">
  <a class="nav-link" id="plot" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" data-toggle="collapse" href="#">Plot Hydrants</a>
</li>
<li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
  <div class="dropdown-menu" aria-labelledby="dropdown01">
    <a class="dropdown-item" href="#" data-toggle="collapse" >View Profile</a>
    <a id="logout" class="dropdown-item" href="#" data-toggle="collapse" >Logout</a>
  </div>
</li>
<div>
  
</div>
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
  $("#home").click(function(){
    $("#loading").show();
      $.ajax({
        url: "http://wordpresssample11.000webhostapp.com/mobile-server/get/fireman.php",
        method: "POST",
        data:{
          'u_reg_id': $("#u_reg_id").val()
        },
        success: function(data){
          $("#loading").hide();
          $("#container").html("");
          $("#container").html(data);
        }
      });
  });
  $("#plot").click(function(){
    $("#loading").show();
      $.ajax({
        url: "http://wordpresssample11.000webhostapp.com/mobile-server/get/plot.php",
        method: "GET",
        success: function(data){
          $("#loading").hide();
          $("#container").html("");
          $("#container").html(data);
        }
      });
  });
</script>