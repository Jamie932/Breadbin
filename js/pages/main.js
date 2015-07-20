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
        
       var line = new ProgressBar.Line('#upload', {
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
                var instrucArray = new Array();
                var prepComTime = new Array();
                var cookComTime = new Array();
        
                $("input[name=recipeIngredients]").each(function() {
                   ingredArray.push($(this).val());
                });
        
                $("textarea[name=recipeInstructions]").each(function() {
                   instrucArray.push($(this).val());
                });
        
                $("input[name=recipePrepTime]").each(function() {
                   prepComTime.push($(this).val());
                });
        
                 $("input[name=recipeTime]").each(function() {
                   cookComTime.push($(this).val());
                });

                alert(instrucArray); 
        
                
        
                    var formData = {
                        'title' : $('#recipeTitle').val(),
                        'time' : $('#recipeTime').val(),
                        'prepTime' : JSON.stringify(prepComTime),
                        'cookTime' : JSON.stringify(cookComTime),
                        'serves' : $('#recipeServe').val(),
                        'ingredients' : JSON.stringify(ingredArray),
                        'instructions' : JSON.stringify(instrucArray)
                    };

                    $.ajax({
                        type        : 'POST',
                        url         : 'php/postRecipe.php',
                        data        : formData,
                        dataType    : 'json',
                        encode      : true,
                        error		: function(request, status, error) { console.log(request.responseText); },
                        success		: function(data) {
                            if (data.success) {
                                window.location.replace("main.php");
                            } else {
                                createError(data.error);
                            }
                        }
                })
                    
        event.preventDefault();
        
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
    });
    
    $("#rightTitleRec").click(function(){
        $('#blackOverlay').fadeOut('normal');
        $('#recipeBox').fadeOut('normal');
    });
    
    $("#recipePrepTime").keydown(function (e) {
        $('.bodyHalf').on('keydown', '#recipePrepTime', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    });
    
    $("#recipeTime").keydown(function (e) {
        $('.bodyHalf').on('keydown', '#recipeTime', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    });

function getFile(){
    $('#upfile').click();
}