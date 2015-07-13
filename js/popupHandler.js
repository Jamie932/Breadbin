var isPopup = false;

function createPopup(title, content, yesno) {
    if (title != undefined && content != undefined) {
        $('.popupTitle').html(title);
        $('.popupContent').html(content);
            $('.popupOK').fadeIn();
        
        if (yesno != undefined) { //Two buttons - OK and Cancel
            $('.popupCancel').fadeIn();
        }
        
        $('#popup').fadeIn();
    } else {
        alert("Error making a popup");   
    }
}

function clearPopup() {
    
}