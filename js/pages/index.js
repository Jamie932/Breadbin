function resetForm() {
    $('.error').removeClass('error');
    $('small').remove();
}

$(document).ready(function(){
   $(document).on('click','.registerBtn', function() {
       $(".login").fadeOut('normal', function(){
            $(".register").fadeIn('normal');
            $("#mid").addClass('tall');
			
            clearErrors();
       });
	   
		$('.dockBelow').animate({'opacity': 0}, 400, function () { $('.dockBelow').html('Already have an account? <a class="loginBtn">Login</a>') }).animate({'opacity': 1}, 400);
   });
        
   $(document).on('click','.loginBtn', function() {
       $(".register").fadeOut('normal', function(){
            $(".login").fadeIn('normal');
            $("#mid").removeClass('tall');

            clearErrors();
        });
		
		$('.dockBelow').animate({'opacity': 0}, 400, function () { $('.dockBelow').html('Don\'t have an account? <a class="registerBtn">Sign up</a>') }).animate({'opacity': 1}, 400);
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
            encode      : true,
			error		: function(request, status, error) { console.log(request.responseText); },
			success		: function(data) {
				resetForm();
				if ( !data.success) {
					/*if (data.errors.username) {
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
					}*/
					
					createError("An error has occured with your registration.");

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
						$('.dockBelow').fadeOut();
					 });
				}
			}
		})
            
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
            encode      : true,
			error		: function(request, status, error) { console.log(request.responseText); },
			success		: function(data) {
				resetForm();

				if ( !data.success) {
					if (data.incorrect) {
						createError("Incorrect login details provided.");
					} else if (!data.validation) {
						createError("You have not yet validated your account (check your emails).");
					} else {
						createError("An error has occured with your login.");
					}

				} else {
					window.location.replace("main.php");
				}
			}
        })
		
        event.preventDefault();
    });
    
})