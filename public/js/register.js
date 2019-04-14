$(function() {
	$('#register').click(function(){
		$('#errormsg').text("");
		$.ajax({
            type: "POST",
            url: "util/register.php",
            data: {username: $('#username').val(), password: $('#password').val()},
            success: function(data){
            	$('#errormsg').text(data+"<br><a href='index.html'>Klik hier om terug te gaan</a>");
            },
			error: function(data, status, request){
				$('#errormsg').text(request);
			}
        });
	});
	
});