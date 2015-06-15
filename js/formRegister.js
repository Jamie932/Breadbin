$(document).ready(function() {
    function resetForm() {
		$('.regUserName').removeClass('error');
		$('.regUserEmail').removeClass('error');
		$('.regUserPass').removeClass('error');
		$('.regUserConfirm').removeClass('error');
        
        $('small').remove();
    }
    
    $('#regForm').submit(function(event) {
        var formData = {
            'username' : $('.regUserName').val(),
            'password' : $('.regUserPass').val(),
            'confirmPassword' : $('.regUserPass').val(),
            'email' : $('.regUserEmail').val()
        };

        $.ajax({
            type        : 'POST',
            url         : 'php/register.php',
            data        : formData,
            dataType    : 'json',
            encode      : true
        })
		
		.done(function(data) {
			console.log(data); 
			resetForm();
		
			if ( !data.success) {
				if (data.errors.username) {
					$('.regUserName').addClass('error');
					$('<small>' + data.errors.username + '</small>').hide().appendTo("#regUserName-group").fadeIn(700);
				}

				if (data.errors.password) {
					$('.regUserPass').addClass('error');
					$('<small>' + data.errors.password + '</small>').hide().appendTo("#regUserPass-group").fadeIn(700);
				}
				
				if (data.errors.confirmPassword) {
					$('.regUserConfirm').addClass('error');
					$('<small>' + data.errors.confirmPassword + '</small>').hide().appendTo("#regUserConfirm-group").fadeIn(700);
				}

				if (data.errors.email) {
					$('.regUserEmail').addClass('error')
					$('<small>' + data.errors.email + '</small>').hide().appendTo("#regUserEmail-group").fadeIn(700);
				}

			} else { 
				//window.location.reload();
                
                $(".register").fadeOut('normal', function(){
                    $(".verify").fadeIn('normal');        
			     });
            }
        });
            
        event.preventDefault();
    });
});
