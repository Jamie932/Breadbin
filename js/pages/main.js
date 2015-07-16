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
    
    $('#postRecipeForm').submit(function(event) {
               
                var ingredArray = new Array();
        
                $("input[name=recipeIngredients]").each(function() {
                   ingredArray.push($(this).val());
                });

                alert(ingredArray); 
        
                
        
                    var formData = {
                        'title' : $('#recipeTitle').val(),
                        'ingredients' : JSON.stringify(ingredArray),
                        'instructions' : $('#recipeInstructions').val()
                    };

                    $.ajax({
                        type        : 'POST',
                        url         : 'php/postRecipe.php',
                        data        : formData,
                        dataType    : 'json',
                        encode      : true,
                        success: function(data) {
                        if (!data.success) {
                            alert("error");
                            createError(data.error);
                        } else {
                            window.location.replace("settings.php"); 
                        }
                    })
                });
                    
        event.preventDefault();
        
    })

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
    
    $("#load").click(function(e){ // click event for load more
        e.preventDefault();
    });
})

function getFile(){
    $('#upfile').click();
}

function add_fields() {
    document.getElementById('Ingredients').innerHTML += '<input type="text" name="recipeIngredients" id="recipeIngredients" placeholder="Recipe Ingredient" class="recipeIngredients"/>';
}