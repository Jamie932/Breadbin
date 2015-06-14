$(document).ready(function() {
    if ($.cookie('username')) {
        $('.in').add();
        $('.out').remove();
    } else {
        $('.in').remove();
        $('.out').add();
    }
});