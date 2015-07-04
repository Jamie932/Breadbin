function submitAvatar() {
    var formData = new FormData();    
    var has_selected_file = $('input[type=file]').filter(function(){return $.trim(this.value) != ''}).length  > 0;

    if (has_selected_file) {
        var file = $('input[type=file]')[0].files[0];

        if (file['size'] < 2097152) {
            formData.append( 'file', file );
        }

        $.ajax({
            type        : 'POST',
            url         : 'php/changeAvatar.php',
            processData : false,
            contentType : false,
            cache       : false,
            data        : formData,
            success     : function (response) {
                $('#userAvatar').css('background', 'url(' + response +') no-repeat !important');
            },
            error       : function(xhr, ajaxOptions, ThrownError){
                alert("Error: " + ThrownError);
            }

        })
    }

    event.preventDefault();
};