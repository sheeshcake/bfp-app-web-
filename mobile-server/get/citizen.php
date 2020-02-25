<div id="main">
    <div style="padding-top: 23%;">
        <h1>Welcome Citizen!</h1>
    </div>
    <div id="ui" class="jumbotron" style="display: none">
        <div id="map_canvas" style="height: 100%;border-radius: 5px;padding-top: 100%;">
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-success" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
        <br>
        <br>
        <center><button id="details" class="btn btn-primary">Open Details</button></center>
        <br>
        <div id="details_cont" style="display: none;">
            <img id="img" src = ""/>
            <input type="text" name="location" id="incident_lat" hidden>
            <input type="text" name="location" id="incident_long" hidden>
            <img id="imageURI" src="" hidden>
            <input type="file" name="image" id="image">
            <p id="desc"></p>
        </div>
    </div>
    <center>
        <button id="report" style="width: 90%; margin:  2%;" class="btn btn-primary">Report My Location</button>
        <button id="send_data" class="btn btn-danger" style="display: block;">Send Report</button>
    </center>
</div>
<script type="text/javascript">
    var image_loc = "img/logo.png";
    var your_loc;
    var dept_data = [];
    $('#report').click(function(){
        navigator.camera.getPicture(onSuccess, onFail, { quality: 50, destinationType: Camera.DestinationType.FILE_URI }); 
    });
    $('#details').click(function(){
        var image = document.getElementById('img');
        var cont = document.getElementById('details_cont');
        if (cont.style.display === 'none') {
            console.log("open");
            cont.style.display = 'block';
        }
        else {
            console.log("close");
            cont.style.display = 'none';
        }
        var map = document.getElementById('map_canvas').offsetWidth;
        document.getElementById('desc').innerHTML = your_loc;
        image.style.width = map + "px";
        image.src = image_loc;
        document.getElementById("report").style.display = "none";
        document.getElementById("send").style.display = "block";
    });
    function showCountry(lat, lon) {
        try{
            console.log("searching");
            $.ajax({
                url: "http://nominatim.openstreetmap.org/reverse?lat=" + lat + "&lon=" + lon + "json_callback=?&format=json",
                method: "GET",
                success: function(data){
                    console.log(data);
                }
            })
           //  $.getJSON('http://nominatim.openstreetmap.org/reverse?json_callback=?&format=json', {lat: lat, lon: lon}, function(data) {
           //     var res_data = JSON.parse(data);
           //     console.log(data);
           //     console.log(res_data.display_name);
           // });
            console.log("done");
        }catch(e){
            console.log(e);
        }
    }

    function get_data(data){
        dept_data = data;
        console.log(data);
        console.log(dept_data);
        navigator.geolocation.getCurrentPosition(function(position) {
            var point = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            // Initialize the Google Maps API v3
            your_loc = "Your Coordinates is: latitude: " + position.coords.latitude +
                        ", longitude: " + position.coords.longitude;
            var map = new google.maps.Map(document.getElementById('map_canvas'), {
                zoomControl: false,
                mapTypeControl: false,
                scaleControl: false,
                streetViewControl: false,
                rotateControl: false,
                zoom: 26,
                center: point,
                mapTypeId: google.maps.MapTypeId.SATELLITE
            });
            try{
                dept_data.forEach(function (arrayItem) {
                    if(arrayItem){
                        console.log(arrayItem.dept_name);
                        var dept_points = new google.maps.LatLng(arrayItem.dept_lat, arrayItem.dept_long);
                        var dept_marker = new google.maps.Marker({
                            position: dept_points,
                            map: map,
                            title: arrayItem.dept_name
                        });
                        // attachDeptName(marker, arrayItem.dept_name);
                    }
                });
                // console.log(data);
                // Place a marker
                var marker = new google.maps.Marker({
                    position: point,
                    map: map,
                    title: "This is your Location"
                });
                document.getElementById("incident_lat").val = position.coords.latitude;
                document.getElementById("incident_long").val = position.coords.longitude;
                var contentString = '<div id="content">'+
                    'This is your location' +
                    '</div>';
                var infowindow = new google.maps.InfoWindow({
                    content: contentString
                });
                marker.addListener('click', function() {
                    infowindow.open(map, marker);
                });
                showCountry(position.coords.latitude, position.coords.longitude);

                }catch(e){
                console.log("ERROR!" + e);
            }
        });
    }


    var imageURI = "";
    function onSuccess(imageURI) {
        try{
            document.getElementById("imageURI").val = imageURI;
            image_loc = imageURI;
            var image = document.getElementById('img');
            var map = document.getElementById('map_canvas').offsetWidth;
            image.style.width = map + "px";
            image.src = image_loc;
            document.getElementById('ui').style.display = 'block';
            $.ajax({
                        type: "POST",
                        url: "http://wordpresssample11.000webhostapp.com/mobile-server/get-departments.php",
                        data:{
                            'get': 'true'
                        },
                        success: function(response){
                            console.log(response);
                            try{
                                dept_data = JSON.parse(response);
                                get_data(dept_data);

                            }catch(e){
                                console.log(e);
                            }
                        }

                    });
        }catch(e){
            alert(e);
        }

    }



    function onFail(message) {
        alert('Failed because: ' + message);
    }


    var report = false;

    function check_reports(){
        report = true;
        $.ajax({
            url: "http://wordpresssample11.000webhostapp.com/mobile-server/get_alerts.php",
            method: "POST",
            data:{
                'type': 'check',
                'id': "" + $("dept_id").val()
            },
            success: function(data){
                try{
                    var myLocation = {lat: parseFloat($("my_lat").val()),lng: parseFloat($("my_long").val())};
                    var incident_LatLng = {lat: data.incident_lat, lng: data.incident_long};
                    var map = new google.maps.Map(document.getElementById('drive_map'), {
                        zoom: 26,
                        mapTypeId: 'satellite',
                        center: myLocation
                    });
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
        });
    }

    $('#send_data').click(function() {
        console.log("clicked send report");
        if(handshake()){
            try{
                console.log(image_loc);
                if(uploadImage()){
                    console.log("sending reports");
                }
                else{
                    console.log("error on upload");
                }
            }
            catch(e){
                alert(e);
            }
        }
        else{
            alert("ERROR handshake to server!");
        }
    });

    /// upload image
    function uploadImage(){
        var imageURI = image_loc;
        var options = new FileUploadOptions();
        options.fileKey = "file";
        options.fileName = imageURI.substr(imageURI.lastIndexOf('/') + 1);
        options.mimeType = "image/jpeg";
        var ft = new FileTransfer();
        if(ft.upload(
            imageURI, 
            // "http://localhost/bfp/mobile-server/recieve-photo.php",
            "http://wordpresssample11.000webhostapp.com/mobile-server/recieve-photo.php",
            function(result) {
                // console.log(uploadImage_loc);
                if(uploadData()){
                    //alert("INCIDENT REPORTED!!");
                }
                console.log("upload complete: " + JSON.stringify(result));
                return true;
            },
            function(error) {
                console.log("upload error: " + JSON.stringify(error));
                return false;
            }, options)){
            console.log("true");
            return true;
        }
        else{
            console.log("fale");
            return false;
        }

    }
    /// upload data to server
    function uploadData(){
        console.log("uploading");
        // console.log(uploadImage_loc);
        var image = document.getElementById("imageURI").val
        console.log(document.getElementById("imageURI").val + " " + image);
        console.log("image location: " + document.getElementById("incident_lat").val + "," + document.getElementById("incident_long").val);
        try{
            $.ajax({
                type: "POST",
                url: "http://wordpresssample11.000webhostapp.com/mobile-server/get-departments.php",
                data:{
                    'calculate': 'true',
                    'user_lat': document.getElementById("incident_lat").val,
                    'user_long': document.getElementById("incident_long").val
                },
                success: function(response){
                    var dept = JSON.parse(response);
                    alert("Reported to '" + dept.dept_name + "' Which is the nearest Fire Department");
                    $.ajax({
                        url: "http://wordpresssample11.000webhostapp.com/mobile-server/recieve-report.php",
                        type: "POST",
                        data: {
                            'file_id': image.substr(image.lastIndexOf('/') + 1),
                            'user_id': $("#u_reg_id").val(),
                            'incident_lat': document.getElementById("incident_lat").val,
                            'incident_long': document.getElementById("incident_long").val,
                            'dept_id': dept.dept_id
                        },
                        success: function(response){
                            console.log(response);
                        }
                    });
                }
            });
        }catch(e){
            console.log(e);
            return false;
        }
        return true;
        // var file_data = $('#image').prop('files')[0];
        // if(!file_data = $('#image').prop('files')[0])) file_data = document.getElementById("youtubeimg").src; else alert('error');
        // alert(document.getElementById("img").src);
        // alert(JSON.stringify(file_data));
        // var form_data = new FormData();  // Create a FormData object
        // // form_data.append('file', file_data);  // Append all element in FormData  object
        // form_data.append('file_id', document.getElementById(image_loc.substr(image_loc.lastIndexOf('/') + 1)));
        // form_data.append('user_id', document.getElementById("user_id").val);
        // form_data.append('incident_loc', document.g  etElementById("incident_loc").val);
        // $.ajax({
        //         // url         : 'http://localhost/bfp/mobile-server/recieve-report.php',   // point to server-side PHP script 
        //         url: "http://halfbyte.000webhostapp.com/mobile-server/recieve-report.php",
        //         // dataType    : 'text',           // what to expect back from the PHP script, if anything
        //         data        : form_data,                         
        //         type        : 'post',
        //         success     : function(output){
        //             console.log(output);
        //             alert(output);              // display response from the PHP script, if any
        //         }
        //  });
         // $('#image').val('');                     /* Clear the input type file */
    }

</script>