function resetForm() {
    $('.error').removeClass('error');
    $('small').remove();
}

function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');

    for (var i = 0; i < sURLVariables.length; i++) {   
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) {
            return sParameterName[1];
        }
    }
}

$(document).ready(function(){
	if (getUrlParameter('ref')) {
		if (getUrlParameter('ref') == 'redirect') {
			createError("Sorry the requested content is not available to view without being logged in.");
			window.location.href = window.location.href.split('?')[0];
		} else if (getUrlParameter('ref') == 'expired') {
			createError("Please re-login as your session has expired.");
			window.location.href = window.location.href.split('?')[0];
		}
	}
	
   $(document).on('click','.registerBtn', function() {
		$(".active").fadeOut('normal', function(){
			$("#mid").addClass('tall');
			$(".active").removeClass('active');
			
			$(".register").fadeIn('normal');
			$(".register").addClass('active');
			
			clearErrors();
		});
	   
		$('.dockBelow').animate({'opacity': 0}, 400, function () { $('.dockBelow').html('Already have an account? <a class="loginBtn">Login</a>') }).animate({'opacity': 1}, 400);
   });
        
   $(document).on('click','.loginBtn', function() {
		$(".active").fadeOut('normal', function(){
			$("#mid").removeClass('tall');
			$(".active").removeClass('active');
			
			$(".login").fadeIn('normal');
			$(".login").addClass('active');
			
			clearErrors();
		});
		
		$('.dockBelow').animate({'opacity': 0}, 400, function () { $('.dockBelow').html('Don\'t have an account? <a class="registerBtn">Sign up</a>') }).animate({'opacity': 1}, 400);
   });
   
   $(document).on('click','.termsBtn', function() {
		$(".active").fadeOut('normal', function(){
			$("#mid").removeClass('tall');
			$(".active").removeClass('active');
			
			$(".terms").fadeIn('normal');
			$(".terms").addClass('active');
			
			clearErrors();
		});
		
		$('.dockBelow').animate({'opacity': 0}, 400, function () { $('.dockBelow').html('<a class="loginBtn">Login</a> or <a class="registerBtn">Sign up</a>') }).animate({'opacity': 1}, 400);
   });
   
    $(document).on('click','.privacyBtn', function() {
		$(".active").fadeOut('normal', function(){
			$("#mid").removeClass('tall');
			$(".active").removeClass('active');
			
			$(".privacy").fadeIn('normal');
			$(".privacy").addClass('active');
			
			clearErrors();
		});
		
		$('.dockBelow').animate({'opacity': 0}, 400, function () { $('.dockBelow').html('<a class="loginBtn">Login</a> or <a class="registerBtn">Sign up</a>') }).animate({'opacity': 1}, 400);
   });
   
    $(document).on('click','.aboutBtn', function() {
		$(".active").fadeOut('normal', function(){
			$("#mid").removeClass('tall');
			$(".active").removeClass('active');
			
			$(".about").fadeIn('normal');
			$(".about").addClass('active');
			
			clearErrors();
		});
		
		$('.dockBelow').animate({'opacity': 0}, 400, function () { $('.dockBelow').html('<a class="loginBtn">Login</a> or <a class="registerBtn">Sign up</a>') }).animate({'opacity': 1}, 400);
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

					$(".active").fadeOut('normal', function(){
						$(".active").removeClass('active');
						$("#mid").removeClass('tall');
						
						$(".verify").fadeIn('normal');
						$(".verify").addClass('active');
			
						clearErrors();
						$('.dockBelow').animate({'opacity': 0}, 400, function () { $('.dockBelow').html('Once you\'ve verified, please <a class="loginBtn">login</a>') }).animate({'opacity': 1}, 400);
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