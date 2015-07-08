function createError(errorMessage) { //Improve this later by pushing content down automatically!
    $('#errorBar').animate({height: "35px"}, 500);
    $('#errorBar').html("ERROR: " + errorMessage.toLowerCase());

    if ($('#profileContainer').length) {
        $('#profileContainer').animate({marginTop: "35px"}, 500);
    } else if ($('#center').length) {
        $('#center').animate({paddingTop: "35px"}, 500);
    }
}