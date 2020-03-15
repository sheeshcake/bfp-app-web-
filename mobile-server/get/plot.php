<br>
<br>
<br>
<br>

<div class="jumbotron">
	<div id="map_canvas" style="height: 100%;border-radius: 5px;padding-top: 100%;">
        <div class="d-flex justify-content-center">
            <div class="spinner-border text-success" role="status">
              <span class="sr-only">Waiting to take a photo..</span>
            </div>
        </div>
	</div>
	<br>
	<br>
	<center><button class="btn btn-primary" id="report">Add Hydrant</button></center>
	<br>
	<center><div id="stat"></div></center>
</div>

<script type="text/javascript">
	var map;
	var marker;
	load();
	function load(){
		// alert("Loading");
		try{
			navigator.geolocation.getCurrentPosition(function(position) {
				var point = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
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
		        var marker = new google.maps.Marker({
		            position: point,
		            map: map,
		            title: "This is your Location"
		        });
	    	});	
		}catch(e){
			alert(e);
		}
	}
    $('#report').click(function(){
    	try{
    		navigator.camera.getPicture(onSuccess, onFail, { quality: 50, destinationType: Camera.DestinationType.FILE_URI }); 
    	}catch(e){
    		alert(e);
    	}
    });
    function onSuccess(imageURI){
    	$("#stat").append("<h3>Uploading Data</h3>");
    	navigator.geolocation.getCurrentPosition(function(position) {
	        var options = new FileUploadOptions();
			options.fileKey = "file";
			options.fileName = imageURI.substr(imageURI.lastIndexOf('/') + 1);
			options.mimeType = "image/jpeg";
			var ft = new FileTransfer();
			try{
				ft.upload(
					imageURI,
					"http://wordpresssample11.000webhostapp.com/mobile-server/recieve-hydrant-photo.php",
					function(result){
						// alert("Success! " + options.fileName + " " + $("#u_reg_id").val());
			    		$.ajax({
			    			url: "http://wordpresssample11.000webhostapp.com/mobile-server/plot_hydrants.php",
			    			method: "POST",
			    			data:{
			    				'dept_id': $("#u_reg_id").val(),
			    				'hydrant_lat': position.coords.latitude,
			    				'hydrant_long': position.coords.longitude,
			    				'image_name': options.fileName
			    			},
			    			success: function(data){
			    				alert(data);
			    				$("#stat").html("");
			    				$("#stat").append("<h3>" + data + "</h3>");
				                var contentString = '<img id="image" src=' + imageURI + '>';
				                var infowindow = new google.maps.InfoWindow({
				                    content: contentString
				                });
			                    infowindow.open(map, marker);
			    			},
			    		});
						return true;
					},
					function(error){
						alert("Error: " + error);
						$("#stat").append("<h3>" + error + "</h3>");
						return false;
					},
					options
				);
			}catch(e){
				alert(e);
			}
    	});
    }
    function onFail(message){
    	alert("Fail Because: " + message);
    }
</script>