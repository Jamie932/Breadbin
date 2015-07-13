var isPopup = false;

function createPopup(title, content) {
    if (title != undefined && content != undefined) {
        $('.popupTitle').html(title);
        $('.popupContent').html(content);
        $('#popup').fadeIn();
    } else {
        alert("Error making a popup");   
    }
}

function clearPopup() {
    
}