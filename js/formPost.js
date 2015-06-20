$(document).ready(function() {   
    var errorExists = false;

    $('#postForm').submit(function(event) {
        var formData = new FormData();    
        var has_selected_file = $('input[type=file]').filter(function(){return $.trim(this.value) != ''}).length  > 0;
        
        if (has_selected_file) {
            var file = $('input[type=file]')[0].files[0];
            
            if (file['size'] < 2097152) {
                formData.append( 'file', file );
            } else {
                if (!errorExists) {
                    $('#error').css({"height":"30px"});
                    $('<div class="error"><b>Error:</b> The max file size is 2MB.</div>').hide().appendTo($('#error')).fadeIn(1000);
                    errorExists = true;
                    return false;
                }
            }
        }
        
        errorExists = false;    
            
        if ($.trim($('.postText').val())) {
            formData.append('text', $('.postText').val());
        }

        $.ajax({
            type        : 'POST',
            url         : 'php/post.php',
            processData : false,
            contentType : false,
            cache       : false,
            data        : formData,
            success     : function (response) {
				window.location.replace("main.php");
            },
            error       : function(xhr, ajaxOptions, ThrownError){
                alert("Error: " + ThrownError);
            }
            
        })
		
		/*.done(function(data) {
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
		});*/
		
        event.preventDefault();
    });

});
