var isPopup = false;

function createPopup(title, content, yesno, clicked) {
    if (title != undefined && content != undefined) {
        $('#leftTitle').html(title);
        $('#popupContent').html(content);
    } else if (title != undefined) {
        $('#leftTitle').html('Breadbin');
        $('#popupContent').html(title);
    } else {
        createError("PopUp failed to be created.");
    }
        
    $('.popupOK').fadeIn();
    
    if (yesno != undefined && yesno) { //Two buttons - OK and Cancel
        $('.popupCancel').fadeIn();
        
        if (clicked) {
            $('.popupOK').click(clicked);
        }
    } else {
        $('.popupOK').click(function() { clearPopup()  });
    }
        
    $('#popup').fadeIn();
}

function clearPopup() {
    $('#popup').fadeOut('normal', function() { 
        $('#leftTitle').html('');
        $('#popupContent').html('');
    });
    $('.popupCancel').fadeOut();
    $('.popupOK').fadeOut();
}

$(document).ready(function() {
    $('.popupCancel').click(function() {
      clearPopup();
    });

    $('#rightTitle .fa').click(function() {
      clearPopup();
    });
})  