function submitAvatar() {
    var formData = new FormData();    
    var has_selected_file = $('input[type=file]').filter(function(){return $.trim(this.value) != ''}).length  > 0;

    if (has_selected_file) {
        var file = $('input[type=file]')[0].files[0];

        if (file['size'] < 2097152) {
            formData.append( 'file', file );
        }

        $('#progressBar').animate({ height: 5px }, 600);
        $('#profileContainer').animate({ margin-top : 5px }, 600);
        
        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        $('#innerProgress').width(Math.round(percentComplete * 100) + '%');
                    }
               }, false);
                
               return xhr;
            },
            type        : 'POST',
            url         : 'php/changeAvatar.php',
            processData : false,
            contentType : false,
            cache       : false,
            data        : formData,
            success     : function (response) {
                //$('#userAvatar').css('background', "url('" + response + "?r=" + new Date().getTime() + "') no-repeat");
                window.location.replace("profile.php");
            }, 
            error       : function(xhr, ajaxOptions, ThrownError){
                alert("Error: " + ThrownError);
            }

        })
    }
};