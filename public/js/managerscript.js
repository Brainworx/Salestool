$(function() {
	$('#fix').click(function(){
		$('#errormsg').text("");
		$.ajax({
            type: "POST",
            url: "util/locfixer.php",
            data: {limit: $('#limit').val()},
            success: function(data){
            	$('#errormsg').text(data);
            },
			error: function(data, status, request){
				$('#errormsg').text(request);
			}
        });
	});
	
});


