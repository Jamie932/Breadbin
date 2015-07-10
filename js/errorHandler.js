var isError = false;

function createError(errorMessage) {
    if (!isError) {
        ifError = true;
        $('#errorBar').animate({height: "35px"}, 500, function() { $('#errorClose').animate({opacity:1}, 200); });
        $('#errorText').html(errorMessage);

        if ($('#profileContainer').length) {
            $('#profileContainer').animate({marginTop: "35px"}, 500);
        } else if ($('#center').length) {
            $('#center').animate({paddingTop: "35px"}, 500);
        }
    } else {
        $('#errorBar').fadeIn(100).fadeOut(100).fadeIn(100);
        $('#errorText').html(errorMessage);
    }
}

function clearErrors() {
    isError = false;
    $('#errorClose').animate({opacity:0}, 200);
    $('#errorBar').animate({height: "0px"}, 500);
    $('#errorText').html("");  
    
    if ($('#profileContainer').length) {
        $('#profileContainer').animate({marginTop: "0px"}, 500);
    } else if ($('#center').length) {
        $('#center').animate({paddingTop: "0px"}, 500);
    }    
}