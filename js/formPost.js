$(document).ready(function() {    
    $('#postForm').submit(function(event) {
        var formData = {
            'text' : $('.postText').val()
        };

        $.ajax({
            type        : 'POST',
            url         : 'php/post.php',
            data        : formData,
            dataType    : 'json',
            encode      : true
        })
		
		.done(function(data) {
			console.log(data);
		
			if (!data.success) {
                $('#error').css({"height":"30px"});
                
                $("<b>Error:</b> " + data.errors.text).hide().appendTo('#error').fadeIn(1000);
			} else {
				window.location.replace("main.php");
			}
		});
		
        event.preventDefault();
    });

});
