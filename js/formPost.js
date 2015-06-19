$(document).ready(function() {   
    var errorExists = false; 
    
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
                if (!errorExists) {
                    $('#error').css({"height":"30px"});
                    $('<div class="error"><b>Error:</b> ' + data.errors.text+ '</div>').hide().appendTo($('#error')).fadeIn(1000);
        
                    errorExists = true;
                    
                }
			} else {
                $('#error').css({"height":"0px"}); 
                $('#error').empty();

                errorExists = false;
				window.location.replace("main.php");
			}
		});
		
        event.preventDefault();
    });

});
