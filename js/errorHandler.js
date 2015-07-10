function createError(errorMessage) {
    $('#errorBar').animate({height: "35px"}, 500, function() { $('#errorClose').fadeIn(); });
    $('#errorText').html(errorMessage);

    if ($('#profileContainer').length) {
        $('#profileContainer').animate({marginTop: "35px"}, 500);
    } else if ($('#center').length) {
        $('#center').animate({paddingTop: "35px"}, 500);
    }
}

function clearErrors() {
    $('#errorClose').fadeOut();
    $('#errorBar').animate({height: "0px"}, 500);
    $('#errorText').html("");  
    
    if ($('#profileContainer').length) {
        $('#profileContainer').animate({marginTop: "0px"}, 500);
    } else if ($('#center').length) {
        $('#center').animate({paddingTop: "0px"}, 500);
    }    
}