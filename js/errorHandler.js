function createError(errorMessage) {
    $('#errorBar').animate({height: "35px"}, 500);
    $('#errorBar').html("ERROR: " + errorMessage);

    if ($('#profileContainer').length) {
        $('#profileContainer').animate({marginTop: "35px"}, 500);
    } else if ($('#center').length) {
        $('#center').animate({paddingTop: "35px"}, 500);
    }
}

function clearErrors() {
    $('#errorBar').animate({height: "0px"}, 500);
    $('#errorBar').html("");  
    
    if ($('#profileContainer').length) {
        $('#profileContainer').animate({marginTop: "0px"}, 500);
    } else if ($('#center').length) {
        $('#center').animate({paddingTop: "0px"}, 500);
    }    
}