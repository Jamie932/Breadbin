var uploadingFile = false;

function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');

    for (var i = 0; i < sURLVariables.length; i++) {   
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) {
            return sParameterName[1];
        }
    }
}

$(document).ready(function() {    
    $(document).on('click','#followBut', function() { 
        var formData = {
            'url' : getUrlParameter('id')
        };

        $.ajax({
            type        : 'POST',
            url         : 'php/follow.php',
            data        : formData,
            dataType    : 'json',
            encode      : true,
            success:function(data) {
                if (!data.success) {
                    createError(data.error);
                }
            }
        })

        $('.followers').html(parseInt($('.followers').text()) + 1);
        $('#followBut').replaceWith('<button id="unFollowBut" class="buttonstyle">Unfollow</button>');   
    });

    $(document).on('click','#unFollowBut', function() {
        var formData = {
            'url' : getUrlParameter('id')
        };

        $.ajax({
            type        : 'POST',
            url         : 'php/unfollow.php',
            data        : formData,
            dataType    : 'json',
            encode      : true
        })

        $('.followers').html(parseInt($('.followers').text()) - 1);
        $('#unFollowBut').replaceWith('<button id="followBut" class="buttonstyle">Follow</button>');
    });

    var lastBio = "";
    var editing = false;

    $("#avatarOverlay").click(function(){
        if ($('.bioRow').attr("contentEditable") != "true") {
            $('.bioRow').attr('contenteditable','true');
            $('.bioRow').addClass('editableContent');
            $('#userAvatar').addClass('editableContent');

            $('#blackOverlay').fadeIn('normal');
            $('#leftProfile').animate({backgroundColor:'#7B7B7B'}, 400);
            $('.saveBut').fadeIn('normal');
            $('#starOverlay').fadeOut('normal');
            $('#avatarOverlay').css('cursor', 'default');

            lastBio = $('.bioRow').text();
            editing  = true;
        }
    });   

    $(document).on('click','.saveBut', function() {
        if (lastBio != $('.bioRow').text()) {
            var confirmed = confirm("Would you like to save these changes?");

            if (confirmed) {
                var formData = {
                    'content' : $('.bioRow').text()
                };

                $.ajax({
                    type        : 'POST',
                    url         : 'php/updateBio.php',
                    data        : formData,
                    dataType    : 'json',
                    encode      : true
                })
            } else {
                $('.bioRow').text(lastBio);   
            }
        }

        $('.bioRow').attr('contenteditable','false');
        $('.bioRow').removeClass('editableContent');
        $('#userAvatar').removeClass('editableContent');
        $('#blackOverlay').fadeOut('normal');
        $('#leftProfile').animate({backgroundColor:'#FFF'}, 400);
        $('.saveBut').fadeOut('normal');
        $('#starOverlay').fadeIn('normal');
        $('#avatarOverlay').css('cursor', 'pointer');
        editing = false;
    });

    $(window).bind("beforeunload", function(event) {
       if (editing && (lastBio != $('.bioRow').text())) return "You have unsaved changes"; 
    });

    $('.bioRow').keypress(function(e) {
        return e.which != 13;
    });

    $('.bioRow').keydown(function(e){ 
        if (e.which != 8 && $('.bioRow').text().length > 140) {
            createError("You have reached the 140 character limit."); 
            e.preventDefault();
        }    
    });

    $('.bioRow').bind("cut copy paste",function(e) {
      e.preventDefault();
    });

    $(document).on('click','#userAvatar', function() {
        if (editing) {
            if (!uploadingFile) {
                $('#upfile').click();
            }
        }
    });

    $("#upfile").change(function (){
        uploadingFile = true;
    });
})

function submitAvatar() {
    var formData = new FormData();    
    var has_selected_file = $('input[type=file]').filter(function(){return $.trim(this.value) != ''}).length  > 0;

    if (has_selected_file) {
        var file = $('input[type=file]')[0].files[0];

        if (file['size'] < 2097152) {
            formData.append( 'file', file );
        } else {
            createError("The max file size is 2MB."); 
            return false;
        }
        
        var circle = new ProgressBar.Circle('#userAvatar', {
            color: '#FFB540',
            strokeWidth: 1,
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
            success     : function (data) {
                data = JSON.parse(data);
                console.log(data);
                
                if (data.success) {
                    var url = data.url.trim() + '?r=' + new Date().getTime();
                
                    $('#userAvatar').css('background-image', 'url(' + url + ')');
                    uploadingFile = false;
                } else {
                    createError(data.error);   
                }
            }, 
            error       : function(xhr, ajaxOptions, ThrownError){
                console.log("Error in the upload.");
            }

        })
    }
};