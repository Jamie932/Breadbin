$(document).ready(function(){
    $('#detailsForm').submit(function(event) {
        var colourSelection = ($('.depressedColour').hasClass('orange') ? '1' : false) || ($('.depressedColour').hasClass('blue') ? '2' : false) || 
            ($('.depressedColour').hasClass('green') ? '3' : false) || ($('.depressedColour').hasClass('red') ? '4' : false) ||
            ($('.depressedColour').hasClass('purple') ? '5' : false) || ($('.depressedColour').hasClass('pink') ? '6' : '');        
        
        var formData = {
            'firstname' : $('#setFirstname').val(),
            'lastname' : $('#setLastname').val(),
            'email' : $('#setEmail').val(),
            'colour' : colourSelection
        };

        
        
        $.ajax({
            type        : 'POST',
            url         : '../php/SettingsUpdate.php',
            data        : formData,
            dataType    : 'json',
            encode      : true
        })
		
		.done(function(data) {
			console.log(data);
		
			if (!data.success) {
                alert("shit error");
			} else {
				window.location.replace("settings.php"); 
			}
		});
		
        event.preventDefault();
    });    
    
    $('.colourBox').click(function() {
        $('.depressedColour').removeClass('depressedColour');
        $('#navbar').css("background-color", $(this).css("background-color"));
        $('.leftHeader').css("background-color", $(this).css("background-color"));

        var active = ($(this).hasClass('orange') ? '#D7870F' : false) || ($(this).hasClass('blue') ? '#4979D8' : false) || 
            ($(this).hasClass('green') ? '#219921' : false) || ($(this).hasClass('red') ? '#DD2B2B' : false) ||
            ($(this).hasClass('purple') ? '#7153B0' : false) || ($(this).hasClass('pink') ? '#C2569E' : false);

        if (active) {
            $('.activePage').css("background-color", active);
			$('.searchBar').css("background-color", active);
			$('#searchIcon').css("background-color", active);
        } 

        $(this).addClass('depressedColour');
    });

    $(".passwordReset").click(function(){
        $(".accountSettingsField").fadeOut('normal', function(){
            $(".passwordSettingsField").fadeIn('normal');
        });
    });

    $('li.settingsList').click(function() {
        if ($(this).hasClass('accountdetails')) {
            $('.settingsBox').fadeOut('fast').promise().done(function() { $('#accountdetailsBox').fadeIn('fast'); });
        } else if ($(this).hasClass('privacy')) {
            $('.settingsBox').fadeOut('fast').promise().done(function() { $('#privacyBox').fadeIn('fast'); });
        } else if ($(this).hasClass('passwordreset')) {
            $('.settingsBox').fadeOut('fast').promise().done(function() { $('#passwordresetBox').fadeIn('fast'); });
        } else if ($(this).hasClass('deleteaccount')) {
            $('.settingsBox').fadeOut('fast').promise().done(function() { $('#deleteaccountBox').fadeIn('fast'); }) ;
        }

        $('.active').removeClass('active');
        $(this).addClass('active');
    });
});

$(window).scroll(function() {
    $('.leftSettings').css('marginLeft', -$(window).scrollLeft()); 
});