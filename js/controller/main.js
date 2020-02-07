var image_loc = "img/logo.png";
var your_loc;


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


function login(){
}



function onSuccess(imageURI) {
    try{
        document.getElementById("imageURI").val = imageURI;
        image_loc = imageURI;
        var image = document.getElementById('img');
        var map = document.getElementById('map_canvas').offsetWidth;
        image.style.width = map + "px";
        image.src = image_loc;
        document.getElementById('ui').style.display = 'block';
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

            // Place a marker
            var marker = new google.maps.Marker({
                position: point,
                map: map,
                title: "This is your Location"
            });

            var contentString = '<div id="content">'+
                '<img alt="image of the incident" style="width:150px" id="map_img" src="' + imageURI +'" style="color: black;">' +
                '</div>';
            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            marker.addListener('click', function() {
                infowindow.open(map, marker);
            });
        });
    }catch(e){
        alert(e);
    }

}



function onFail(message) {
    alert('Failed because: ' + message);
}


