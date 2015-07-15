$(document).ready(function() {  
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
            encode      : true,
            success: function(data) {
                if (data.success) {
				    window.location.replace("settings.php");   
                } else {
                    createError(data.error);
                }
            }
        });
		
        event.preventDefault();
    });

});
