<script type="text/javascript">
    function check_pass(){
        console.log($("#password").val() + " " +  $("#rpassword").val());
        var pass = $("#password").val();
        var rpass = $("#rpassword").val();
        var f_name = $("#f_name").val();
        var l_name = $("#l_name").val();
        var username = $("#username").val();
        if(rpass == "" && pass == ""){
            document.getElementById("prompt").style.color = "red";
            $("#prompt").html("<p>Please input Password!</p>");
            document.getElementById("submit_reg").style.display = "none";
        }
        else{
            if(rpass == pass){
                document.getElementById("prompt").style.color = "green";
                $("#prompt").html("<p>Password Matched!</p>");
                if(f_name != "" && l_name != "" && username != ""){
                    document.getElementById("submit_reg").style.display = "block";
                }
            }
            else{
                document.getElementById("prompt").style.color = "red";
                $("#prompt").html("<p>Password Unmatched!</p>");
                document.getElementById("submit_reg").style.display = "none";
            }
        }
    }
</script>

<div id="register">
    <br><br>
    <a class="btn btn-secondary" id="login_btn">Login</a>
    <center><h1>Register Account</h1></center>
    <div class="jumbotron">
        <form method="POST" action="http://wordpresssample11.000webhostapp.com/mobile-server/user_registration.php" id="user_registration">
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">First Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="f_name" id="f_name" placeholder="Name">
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Last Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="l_name" id="l_name" placeholder="Name">
                </div>
            </div>
            <div class="form-group row">
                <label for="address" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="address" id="address" placeholder="Address">
                </div>
            </div>
            <div class="form-group row">
                <label for="gender" class="col-sm-2 col-form-label">Gender</label>
                <div class="col-sm-10">
                    <select class="form-control" name="gender" id="gender">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="username" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" oninput="check_pass()">
                </div>
            </div>
            <div class="form-group row">
                <label for="rpassword" class="col-sm-2 col-form-label">Retype Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="rpassword" id="rpassword" placeholder="Retype Password" oninput="check_pass()">
                    <div id="prompt" style="color: green"></div>
                </div>
            </div>
            <div class="form-group row">
                <label for="image" class="col-sm-2 col-form-label">Upload Valid ID</label>
                <div class="col-sm-10">
                    <input type="file" name="val-id" id="val-id">
                </div>
            </div>
            <center><input class="btn btn-primary" id="submit_reg" style="display: none" name="submit" type="submit" value="Register"></center>
        </form>
    </div>
</div>

<script type="text/javascript">
    $("#login_btn").click(function(){
        $.ajax({
            url: "http://wordpresssample11.000webhostapp.com/mobile-server/get/login.php",
            method: "GET",  
            success: function(data){
                console.log(data);
                $("#loading").hide();
                $("#container").html(data);
            }
        });
    });
    $("#user_registration").on('submit', function(e){
        e.preventDefault();
        var f_name = $("#f_name").val();
        var l_name = $("#l_name").val();
        var username = $("#username").val();
        var password = $("#password").val();
        var formData = new FormData(this);
        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                alert(data);
            },
            error: function(data){
                console.log("error");
                console.log(data);
            }
        });
    });
</script>