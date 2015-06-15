$(document).ready(function() {
    function resetForm() {
        $('.logUserName').removeClass('error');
        $('.logPassword').removeClass('error');
        
        $('small').remove();
    }
    
    $('#logForm').submit(function(event) {
        var formData = {
            'username' : $('.logUserName').val(),
            'password' : $('.logUserPass').val()
        };

        $.ajax({
            type        : 'POST',
            url         : 'php/login.php',
            data        : formData,
            dataType    : 'json',
            encode      : true
        })
		
		.done(function(data) {
			console.log(data); 
			resetForm();
		
			if ( !data.success) {
				if (data.incorrect) {
					alert("well shit this is wrong yo");
                } else if (!data.validation) {
					alert("You're not validated sorry.");
                } else {
					if (data.errors.username) {
						$('.logUserName').addClass('error');
						$('<small>' + data.errors.username + '</small>').hide().appendTo("#logUserName-group").fadeIn(700);
					}

					if (data.errors.password) {
						$('.logUserPass').addClass('error');
						$('<small>' + data.errors.password + '</small>').hide().appendTo("#logUserPass-group").fadeIn(700);
					}
				}
				
			} else {
				window.location.replace("main.php");
			}
		});
		
        event.preventDefault();
    });

});
