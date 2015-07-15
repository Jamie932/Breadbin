$(document).ready(function(){
   $('#postForm').submit(function(event) {
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
        } else {
            if ($('.postText').val().length == 0) {
                //No text was given
                return false;    
            }   
        }
        
        if ($.trim($('.postText').val())) {
            formData.append('text', $('.postText').val());
        }
        
       var line = new ProgressBar.Line('.upload', {
            color: '#FFB540',
            strokeWidth: 1,
            fill: "rgba(0, 0, 0, 0.5)",
            duration: 1500,
            step: function(state, bar) {
                if (bar.value() == 1) {
                    line.destroy();
                }
            }
        });                   

        $.ajax({
           xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                          line.animate(percentComplete);
                    }
               }, false);
                
               return xhr;
            },
            type        : 'POST',
            url         : 'php/post.php',
            processData : false,
            contentType : false,
            cache       : false,
            data        : formData,                    
            success: function(data) {
                data = JSON.parse(data);
                
                if (data.success) {
				    window.location.replace("main.php");   
                } else {
                    createError(data.error);
                }
            }
        });
        
        event.preventDefault();
    });    
    
    
    $(document).on('click','.delete', function() {
        var confirmed = confirm("Are you sure you want to delete this post?");

        if (confirmed) {
            var postid = $(this).parent().attr('class').split('-')[1];

            var formData = {
                'post' : postid
            };

            $.ajax({
                type        : 'POST',
                url         : 'php/deletePost.php',
                data        : formData,
                dataType    : 'json',
                encode      : true,
                success:function(data) {
                    if (data.success) {
                        //window.location.replace("main.php");
                        //$('.post-' + postid).fadeOut(600, function() { $(this).remove(); });
                        $('.post-' + postid).animate({height: 0, opacity: 0, marginBottom: 0}, 600, function() { $(this).remove();});

                    } else {
                        createError(data.error);
                    }
                }
            })
        }
    })

    $(document).on('click','.toast', function() {
        var postid = $(this).parent().attr('class').split('-')[1]; 
        var totalToasts = $(this).closest('#contentLike').children('.totalToasts');
        var toastButton = $(this).closest('#contentLike').children('.toast');
        var burnButton = $(this).closest('#contentLike').children('.unburn');

        var formData = {
            'post' : postid
        };

        $.ajax({
            type        : 'POST',
            url         : 'php/toast.php',
            data        : formData,
            dataType    : 'json',
            encode      : true
        }) 

        .done(function(data) {
             console.log(data);

            if (!data.success) {
                // Already toasted the post - error.
                createError("This post has already been toasted by you."); 
            } else {
                if (data.removedBurn && data.addedToast) { // Previously toasted
                    totalToasts.html(parseInt(totalToasts.text()) + 2);

                    burnButton.css('color', 'black'); 
                    burnButton.toggleClass('unburn burn');
                } else if (data.removedBurn || data.addedToast) {
                    totalToasts.html(parseInt(totalToasts.text()) + 1);
                } else {
                    createError("Incorrect toast data returned. Please inform an adminstrator."); 
                }

                toastButton.css('color', 'darkgray'); 
                toastButton.toggleClass('toast untoast');
            };
        })
    })

    $(document).on('click','.burn', function() {
        var postid = $(this).parent().attr('class').split('-')[1];
        var totalToasts = $(this).closest('#contentLike').children('.totalToasts');
        var burnButton = $(this).closest('#contentLike').children('.burn');
        var toastButton = $(this).closest('#contentLike').children('.untoast');

        var formData = {
            'post' : postid
        };

        $.ajax({
            type        : 'POST',
            url         : 'php/burn.php',
            data        : formData,
            dataType    : 'json',
            encode      : true
        })

        .done(function(data) {
             console.log(data); 

            if (!data.success) {
                // Already burnt the post - error.
                 createError("This post has already been burnt by you."); 
            } else {
                if (data.removedToast && data.addedBurn) { // Previously toasted
                    totalToasts.html(parseInt(totalToasts.text()) - 2);

                    toastButton.css('color', 'black'); 
                    toastButton.toggleClass('untoast toast');
                } else if (data.removedToast || data.addedBurn) {
                    totalToasts.html(parseInt(totalToasts.text()) - 1);
                } else {
                    createError("Incorrect burn data returned. Please inform an adminstrator."); 
                }

                burnButton.css('color', 'darkgray'); 
                burnButton.toggleClass('burn unburn');
            }
        })
    })

    $(document).ready(function() {

    $('#postRecipeForm').submit(function(event) {
               
            
                var newArray = new Array();

                $('#recipeIngredients').each(function(){
                    newArray.push($(this));
                })
        
                    var formData = {
                        'title' : $('#recipeTitle').val(),
                        'ingredients' : $('#recipeIngredients').val(),
                        'instructions' : $('#recipeInstructions').val()
                    };

                    $.ajax({
                        type        : 'POST',
                        url         : 'php/postRecipe.php',
                        data        : formData,
                        dataType    : 'json',
                        encode      : true
                    })
                    
        event.preventDefault();
        
    })
});

    $(".hide").click(function(){
        $("#contentLikeFollow").hide(500);
        $("#contentPostFollow").hide(500);
    });

    $("#uploadText").keypress(function(event) {
        if(event.which == '13') {
            return false;
        }
    });

    $('input[type=file]').change(function(e){
        $('#uploadname').html($(this).val());
    });
    
    $("#blackout").click(function(){
        $('#blackOverlay').fadeIn('normal');
        $('#recipeBox').fadeIn('normal');
    });
    
    $("#cancel").click(function(){
        $('#blackOverlay').fadeOut('normal');
        $('#recipeBox').fadeOut('normal');
    })   
})

function getFile(){
    $('#upfile').click();
}

function add_fields() {
    document.getElementById('Ingredients').innerHTML += '<input type="text" name="recipeIngredients" id="recipeIngredients" placeholder="Recipe Ingredient" class="recipeIngredients"/>';
}