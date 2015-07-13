$(document).ready(function() {  
    
    $('#detailsForm').submit(function(event) {
        var formData = {
            'firstname' : $('#setFirstname').val(),
            'lastname' : $('#setLastname').val(),
            'email' : $('#setEmail').val(),
            'colour' : $('#setColour').val()
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
                alert('Hello');
			} else {
				alert('Right');
			}
		});
		
        event.preventDefault();
    });

});
