$(document).on('click', '#regibut', function(){
    var username = $('#regUsername').val();
    var password = $('#regPassword').val();
    var confirmpassword = $('#regconfirmpassword').val();
    if (!username) {
        alert("Please enter an username.");
        return false;
    } else if (!password) {
        alert("Please enter a password.");
        return false;
    } else if (!confirmpassword) {
        alert("Please enter a confirmpassword.");
        return false;
    } else if (!(/^[0-9a-zA-Z]{6,}$/).test(username)) {
        alert("Username minimum of 6 characters.");
        return false;
    } else if (!(/^[0-9a-zA-Z]{6,}$/).test(password)) {
        alert("Password minimum of 6 characters.");
        return false;
    } else if (password != confirmpassword) {
        alert("Passwords do not match!");
        return false;
    }
    window.location.replace("main.html");
    return false;
});