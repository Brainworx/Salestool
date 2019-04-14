$(function() {
	$('#login').click(function(){
		$('#errormsg').text("");
		$.ajax({
            type: "POST",
            url: "util/authentication.php",
            data: {username: $('#username').val(), password: $('#password').val()},
            success: function(data, textStatus, request){
            	window.location.replace("main.php");
            },
			error: function(data, status, request){
				$('#errormsg').text(request);
			}
        });
	});
	
});