var keys = {37: 1, 38: 1, 39: 1, 40: 1};

function preventDefault(e) {
  e = e || window.event;
  if (e.preventDefault)
      e.preventDefault();
  e.returnValue = false;  
}

function preventDefaultForScrollKeys(e) {
    if (keys[e.keyCode]) {
        preventDefault(e);
        return false;
    }
}

function disableScroll() {
  if (window.addEventListener) // older FF
      window.addEventListener('DOMMouseScroll', preventDefault, false);
  window.onwheel = preventDefault; // modern standard
  window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
  window.ontouchmove  = preventDefault; // mobile
  document.onkeydown  = preventDefaultForScrollKeys;
}

function enableScroll() {
    if (window.removeEventListener)
        window.removeEventListener('DOMMouseScroll', preventDefault, false);
    window.onmousewheel = document.onmousewheel = null; 
    window.onwheel = null; 
    window.ontouchmove = null;  
    document.onkeydown = null;  
}

$(document).ready(function(){
	$('#uploadText').each(function () {
		this.setAttribute('style', 'height:' + (this.scrollHeight + 2) + 'px;overflow-y:hidden;');
	}).on('input', function () {
	  	this.style.height = 'auto';
	  	this.style.height = (this.scrollHeight + 2) + 'px';
	});
	
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
        
       var line = new ProgressBar.Line('#postForm', {
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
    
    $('#postVideo').submit(function(event) {
        
        var matches = $('#videoLink').val().match(/http:\/\/(?:www\.)?youtube.*watch\?v=([a-zA-Z0-9\-_]+)/);
        var matchesHttps = $('#videoLink').val().match(/https:\/\/(?:www\.)?youtube.*watch\?v=([a-zA-Z0-9\-_]+)/);
        if (matches || matchesHttps)
        {
            alert('valid');
        

                    var formData = {
                        'videoLink' : $('#videoLink').val()
                    };

                    $.ajax({
                        type        : 'POST',
                        url         : 'php/postVideo.php',
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
        }
                    
        event.preventDefault();
        
    });

    $("#uploadText").keypress(function(event) {
        if(event.which == '13') {
            return false;
        }
    });

    $('input[type=file]').change(function(e){
        $('#uploadname').html($(this).val());
    });
    
    $("#gridClick").click(function(){
        disableScroll();
        $('#blackOverlay').fadeIn('normal');
        $('#gridBox').fadeIn('normal');
    });
    
    $(".gridBoxes.1").click(function(){
        $(".innerGrid").fadeOut('normal', function(){
            $('.innerRecipe').fadeIn('normal');
            $("#gridBox").addClass('tall');
        })
    });
    
    $(".gridBoxes.2").click(function(){
        $(".innerGrid").fadeOut('normal', function(){
            $('.innerVideo').fadeIn('normal');
            $("#gridBox").addClass('tall');
        })
    });
    
    $("#cancel").click(function(){
        $('#blackOverlay').fadeOut('normal');
        $("#gridBox").fadeOut('normal', function(){
            $('.innerRecipe').hide();
            $('.innerGrid').show();
        })
        enableScroll();
    });
    
    $("#rightTitleRec").click(function(){
        $('#blackOverlay').fadeOut('normal');
        $("#gridBox").fadeOut('normal', function(){
            $('.innerRecipe').hide();
            $('.innerGrid').show();
        })
        enableScroll();
    });

    $(".recBack").click(function(){
        $("#gridBox").removeClass('tall');
        $(".innerRecipe").fadeOut('normal', function(){
            $('.innerGrid').fadeIn('normal');
        })
    });
    
    $(".vidBack").click(function(){
        $("#gridBox").removeClass('tall');
        $(".innerVideo").fadeOut('normal', function(){
            $('.innerGrid').fadeIn('normal');
        })
    });
    
    $("#recipePrepTime").keydown(function (e) {
        $('.bodyHalf').on('keydown', '#recipePrepTime', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    });
    
    $("#recipePrepTime").keydown(function (e) {
        $('.bodyHalf').on('keydown', '#recipeTime', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    });
    
    $("#recipeTime").keydown(function (e) {
        $('.bodyHalfServe').on('keydown', '#recipeServe', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    });
    
    $(".avHover").hoverIntent( function() { $(this).parent().find(".hoverSpan").slideDown(); } , function() { $(this).parent().find(".hoverSpan").slideUp(); }); 
	
});

$("#videoLink").keydown(function (e) {
     if (e.keyCode == 32) { 
       return false; // return false to prevent space from being added
     }
});

function getFile(){
    $('#upfile').click();
}

$(window).scroll(function() {
    $('#sidebar').css('margin-left', 75 - $(window).scrollLeft()); 
});