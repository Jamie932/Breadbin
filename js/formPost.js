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
                alert("not working");
			} else {
				window.location.replace("main.php");
			}
		});
		
        event.preventDefault();
    });

});
