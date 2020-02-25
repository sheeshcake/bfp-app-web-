<div id="login">
    <center><h1 style="margin-top: 10%;">BFP Login</h1></center>
    <div id="ui" class="jumbotron" style="margin: 2%;">
        <!-- <form> -->
            <div class="form-group row">
                <label for="username" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                </div>
            </div>
            <center><button class="btn btn-primary" id="login_btn">Login</button><a class="btn btn-secondary" style="margin: 2%" id="register_btn">Register</a></center>
        <!-- </form> -->
    </div>
</div>
<script>

$("#register_btn").click(function(){
    $.ajax({
        url: "http://wordpresssample11.000webhostapp.com/mobile-server/get/register.php",
        method: "GET",
        success: function(data){
            $("#container").html("");
            $("#container").html(data);
        }
    }) 
});


$('#login_btn').click(function(){
    if(handshake()){
        let user = $('#username').val();
        let pass = $('#password').val();
        console.log(user + " " + pass);
        $.ajax({
            type: "POST",
            // url: "http://localhost/bfp/mobile-server/login-auth.php",
            url: "http://wordpresssample11.000webhostapp.com/mobile-server/login-auth.php",
            data: {
                'username': user,
                'password': pass
            },
            success: function(response) {
                try{//filtering accounts if its admin or not
                    try{
                        var profile_data = JSON.parse(response.toString());
                        console.log(response);
                        document.getElementById("login").style.display = "none";
                        if(profile_data.role == "fireman"){
                            document.getElementById("fireman").style.display = "block";
                        }   
                        else if(profile_data.role == "admin"){
                            document.getElementById("admin").style.display = "block";
                        }
                        else{
                            document.getElementById("navigation").style.display ="block";
                            $.ajax({
                                url: "http://wordpresssample11.000webhostapp.com/mobile-server/get/citizen.php",
                                method: "POST",
                                data:{'u_reg_id': profile_data.u_reg_id},
                                success: function(data){
                                    console.log(data);
                                    console.log(profile_data.u_reg_id);
                                    $("#container").html("");
                                    $("#container").html(data);
                                }
                            })
                        }
                    }
                    catch(e){
                        alert(response);
                    }
                }
                catch(e){
                    alert("Wrong Username or Password");
                }
            }
        });
    }
    else{
        alert("ERROR handshake to server");
    }
});

</script>