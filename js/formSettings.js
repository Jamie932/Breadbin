$(document).ready(function() {    
    $('.accountSettings').submit(function(event) {
        var formData = {
            'firstname' : $('#setFirstname').val(),
            'lastname' : $('#setLastname').val(),
            'email' : $('#setEmail').val(),
            'colour' : $('#setColour').val()
        };

        $.ajax({
            type        : 'POST',
            url         : '../php/settingsUpdate.php',
            data        : formData,
            dataType    : 'json',
            encode      : true
        })
		
		.done(function(data) {
			console.log(data);
		
			if (!data.success) {
                alert('Hello');
			} else {
				alert('Right');
			}
		});
		
        event.preventDefault();
    });

});
