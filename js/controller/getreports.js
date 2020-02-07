$("#getreports").click(function(){
	console.log("Loading Feed");
	// cordova.InAppBrowser.open(encodeURI('http://ja.m.wikipedia.org/wiki/ハングル'), '_blank', 'hideurlbar=');
	// navigator.app.loadUrl('http://halfbyte.000webhostapp.com/mobile-server/get-reports.php?user_id=' + document.getElementById("user_id").val, { openExternal:true });
	// window.open('http://www.kidzout.com', '_system'); 
	// return false;
	cordova.InAppBrowser.open('http://halfbyte.000webhostapp.com/mobile-server/get-reports.php?user_id=' + document.getElementById("user_id").val, '_blank ', 'location=no,closebuttoncaption=Close');
	// $.ajax({
	// 	type: "POST",
	// 	dataType: "html",
	// 	url: "http://halfbyte.000webhostapp.com/mobile-server/get-reports.php",
	// 	data:{
	// 		'user_id': document.getElementById("user_id").val,
	// 	},
	// 	success: function(html){
	// 		console.log(html);
	// 		document.getElementById("feed").innerHTML = html;
	// 	}
	// });
});