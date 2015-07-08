function submitAvatar() {
    var formData = new FormData();    
    var has_selected_file = $('input[type=file]').filter(function(){return $.trim(this.value) != ''}).length  > 0;

    if (has_selected_file) {
        var file = $('input[type=file]')[0].files[0];

        if (file['size'] < 2097152) {
            formData.append( 'file', file );
        }

        //$('#progressBar').height('5px');
        //$('#profileContainer').css("margin-top", "5px");
        
        var circle = new ProgressBar.Circle('#userAvatar', {
            color: '#FFB540',
            strokeWidth: 2,
            fill: "rgba(0, 0, 0, 0.5)",
            duration: 1500,
            text: {
                value: '0'
            },
            step: function(state, bar) {
                if (bar.value() == 1) {
                    circle.destroy();
                }
                
                bar.setText((bar.value() * 100).toFixed(0));
            }
        });           
        
        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                          circle.animate(percentComplete);
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
                var url = response.trim() + '?r=' + new Date().getTime();
                
                $('#userAvatar').css('background-image', 'url(' + url + ')');
                uploadingFile = false;
                //window.location.replace("profile.php");
            }, 
            error       : function(xhr, ajaxOptions, ThrownError){
                console.log("Error in the upload.");
            }

        })
    }
};