

function handshake(){
    // var status = false;
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    data = mm + '/' + dd + '/' + yyyy + "handshake";
    var form_data = new FormData();
    form_data.append('handshake_data', data);
    // console.log("your data: " + data);
    if(
    $.ajax({
        // url         : 'http://localhost/bfp/mobile-server/handshake.php',     // point to server-side PHP script 
        url         : "http://halfbyte.000webhostapp.com/mobile-server/handshake.php",
        dataType    : 'text',           // what to expect back from the PHP script, if anything
        cache       : false,
        contentType : false,
        processData : false,
        data        : form_data,                         
        type        : 'post',
        success     : function(output){
            if(output.toString() === "true"){
                console.log("handshake complete");
                return true;
            }
            else{
                console.log("handshake error");
                return false;
            }
        }
     })){
        return true;
    }
    else{
        return false;
    }
}