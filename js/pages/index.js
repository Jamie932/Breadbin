function resetForm() {
    $('.error').removeClass('error');
    $('small').remove();
}

$(document).ready(function(){
   $(".registerBtn").click(function(){
       $(".login").fadeOut('normal', function(){
            $(".register").fadeIn('normal');
            $("#mid").addClass('tall');

            $('.logUserName').removeClass('error');
            $('.logUserPass').removeClass('error');
            $('small').remove();
       });
   });
        
   $(".loginBtn").click(function(){
       $(".register").fadeOut('normal', function(){
            $(".login").fadeIn('normal');
            $("#mid").removeClass('tall');

            $('.regUserName').removeClass('error');
            $('.regUserEmail').removeClass('error');
            $('.regUserPass').removeClass('error');
            $('.regUserConfirm').removeClass('error');
            $('small').remove();
        });
   });
    
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
                $.ajax({
                    type        : 'POST',
                    url         : 'php/sendEmail.php',
                    data        : formData,
                    dataType    : 'json',
                    encode      : true
                });
                
                $(".register").fadeOut('normal', function(){
                    $(".verify").fadeIn('normal');        
			     });
            }
        });
            
        event.preventDefault();
    });
    
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
    
})