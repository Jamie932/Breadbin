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
            color: '#FCB03C',
            strokeWidth: 3,
            fill: "rgba(0, 0, 0, 0.5)",
            trailWidth: 1,
            duration: 1500,
            text: {
                value: '0'
            },
            step: function(state, bar) {
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
                circle.destroy()
                //$('#userAvatar').css('background', "url('" + response + "?r=" + new Date().getTime() + "') no-repeat");
                window.location.replace("profile.php");
            }, 
            error       : function(xhr, ajaxOptions, ThrownError){
                alert("Error: " + ThrownError);
            }

        })
    }
};