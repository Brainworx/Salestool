$(function() {
	$('#register').click(function(){
		$('#errormsg').text("");
		$.ajax({
            type: "POST",
            url: "util/register.php",
            data: {username: $('#username').val(), password: $('#password').val()},
            success: function(data){
            	$('#errormsg').text(data);
            },
			error: function(data, status, request){
				$('#errormsg').text(request);
			}
        });
	});
	
});
