<?php 
    require("php/common.php");
    require("php/checkLogin.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Breadbin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="css/common.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="js/vendor/jquery-1.11.2.min.js"></script>
    <script src="js/vendor/jquery.cookie.js"></script>
    <script src="js/errorHandler.js" async></script>
    <script src="js/formPost.js" async></script>
    <script src="js/formRecipePost.js" async></script>
    <script async>
        $(document).ready(function(){
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
        })
        
        function getFile(){
            $('#upfile').click();
        }
        
        $(document).ready(function(){
            $("#blackout").click(function(){
                $('#blackOverlay').fadeIn('normal');
                $('#recipeBox').fadeIn('normal');
            })
        })

        $(document).ready(function(){
            $("#cancel").click(function(){
                $('#blackOverlay').fadeOut('normal');
                $('#recipeBox').fadeOut('normal');
            })
        })

        function add_fields() {
            document.getElementById('Ingredients').innerHTML += '<input type="text" name="recipeIngredients" id="recipeIngredients" placeholder="Recipe Ingredient" class="recipeIngredients"/>';
        }
    </script>
    <script src="js/vendor/progressbar.min.js" async></script>
    
</head>
<body>
    <noscript>
      <META HTTP-EQUIV="Refresh" CONTENT="0;URL=error.php">
    </noscript>    
    
    <?php require('php/template/navbar.php');?>
    <?php require('php/template/popup.php');?>
        
    <div id="break"></div>
        
    <div id="recipeBox">
            <div class="recipeContent">
                <div class="recipeHeader">
                    <h1>Post your recipe</h1>
                </div>

                <hr></hr>
                
                <div id="recipeForm">
                    <form action="php/postRecipe.php" method="POST" id="postRecipeForm" enctype="multipart/form-data">
                        <h3>Recipe Title</h3>
                            <center><input type="text" id="recipeTitle" name="recipeTitle" placeholder="Recipe Title" class="recipeTitle" required/></center>
                        <h3>Ingredients</h3>
                        <div id="Ingredients">
                            <input type="text" name="recipeIngredients" id="recipeIngredients" placeholder="Recipe Ingredient" class="recipeIngredients" style="margin-right: -4px;" required/>
                            <input type="text" name="recipeIngredients" id="recipeIngredients" placeholder="Recipe Ingredient" class="recipeIngredients" style="margin-right: -4px;" required/>
                            <input type="text" name="recipeIngredients" id="recipeIngredients" placeholder="Recipe Ingredient" class="recipeIngredients" style="margin-right: -4px;" />
                            <input type="text" name="recipeIngredients" id="recipeIngredients" placeholder="Recipe Ingredient" class="recipeIngredients" style="margin-right: -4px;" />
                        </div>
                            <center><input type="button" id="more_fields" onclick="add_fields();" value="New Ingredient" /></center>
                        <h3>Recipe Instructions</h3>
                            <center><textarea name="TextUpload" class="recipeInstructions" id="recipeInstructions" maxlength="150" placeholder="Recipe Instructions..."></textarea></center>
                            <center><input type="submit" value="Submit" id="submitRecipe" class="buttonstyle">
                            <input type="button" id="cancel" class="buttonstyle" value="Cancel" /></center>
                    </form>
                </div>
            </div>
        </div>

    <div id="blackOverlay"></div>   
    
    <div id="center">
        <div id="content">
            <?php require('php/fetchPosts.php');?>
        </div>
        
        <div id="sidebar">
            <div class="upload">
                <form action="php/post.php" method="POST" id="postForm" enctype="multipart/form-data">
                    <div class="textarea">
                        <textarea name="TextUpload" class="postText" id="uploadText" maxlength="150" placeholder="Write a slice..."></textarea>
                    </div>
                    
                    <div class="uploadRest">
                        <input type="submit" value="Submit" id="submitPost" class="buttonstyle">
                         
                        <div id="imageIcon"><a href="#" onclick="getFile();"><i class="fa fa-camera"></i></a></div>
                        <div style='height: 0px;width:0px; overflow:hidden;'><input id="upfile" type="file" value="upfile" accept="image/*"/></div>
                        <div id="uploadname"></div>
                    </div>
                </form>
                
                <div id="blackout">
                    <p>blackout</p>
                </div>
                
            </div> 
            <div class="clearFix"></div>
            
            <?php require('php/recommendToaster.php');  ?>
        </div>        
    </div>
</body>
</html>