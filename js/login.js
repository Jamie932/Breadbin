$(document).on('click', '#logbut', function() {
    var username = $('#username').val();
    var password = $('#password').val();
    if (!username) {
        alert("Please enter an username.");
        return false;
    } else if (!password) {
        alert("Please enter a password.");
        return false;
    } else if (!(/^[0-9a-zA-Z]{6,}$/).test(username)) {
        alert("Username minimum of 6 characters.");
        return false;
    } else if (!(/^[0-9a-zA-Z]{6,}$/).test(password)) {
        alert("Password minimum of 6 characters.");
        return;
    }
    $.cookie("username", username, {
        expires: 10
    });
    window.location = "main.html"
    return true;
});