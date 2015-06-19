<?php 
    require("php/common.php");
    require("php/checkLogin.php");
?>
<html>
<head>
    <title>Breadbin - Home</title>
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/jquery.cookie.js"></script>
    <script>
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
                            window.location.replace("main.php");
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
                        alert("not successful soz");
                    } else {
                        if (data.removedBurn && data.addedToast) {
                            // Previously toasted
                            totalToasts.html(parseInt(totalToasts.text()) + 2);
                            burnButton.replaceWith('<p class="burn">Burn</p>');
                        } else if (data.removedBurn || data.addedToast) {
                            totalToasts.html(parseInt(totalToasts.text()) + 1);
                        } else {
                            alert("problem detected woop woop");
                        }
                        
                        toastButton.toggleClass('toast untoast');
                        toastButton.animate({color: 'gray'});
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
                        alert("not successful soz");
                        
                    } else {
                        if (data.removedToast && data.addedBurn) {
                            // Previously toasted
                            totalToasts.html(parseInt(totalToasts.text()) - 2);
                            toastButton.replaceWith('<p class="toast">Toast</p>');
                        } else if (data.removedToast || data.addedBurn) {
                            totalToasts.html(parseInt(totalToasts.text()) - 1);
                        } else {
                            alert("problem detected woop woop");
                        }
                        
                        burnButton.replaceWith('<p class="unburn">Unburn</p>');
                    }
                })
            })
            
            $("#uploadText").keypress(function(event) {
                if(event.which == '13') {
                    return false;
                }
            });
        })
            
    </script>
</head>
<body>
    <noscript>
      <META HTTP-EQUIV="Refresh" CONTENT="0;URL=error.php">
    </noscript>    
    
   <?php require('php/template/navbar.php');?>
    
    <div id="break"></div>
    
    <div id="center">
        <div id="content">
            <?php require('php/fetchPosts.php');?>
        </div>
        
        <div id="sidebar">
            <div class="upload">
                <div class="textarea">
                    <form action="php/post.php" method="POST" id="postForm">
                        <textarea name="TextUpload" class="postText" id="uploadText" maxlength="150" placeholder="Write a slice..."></textarea>
                </div>
                    
                <div class="uploadRest">
                    <a><img src="img/camera.png" height="25px" width="25px" style="vertical-align:top; margin-left:5px;"></a>
                    <a><img src="img/cat.jpg" height="40px" width="40px" style="visibility:hidden;"></a>
                    <a><img src="img/cat.jpg" height="40px" width="40px" style="visibility:hidden;"></a>
                    <a><img src="img/cat.jpg" height="40px" width="40px" style="visibility:hidden;"></a>
                    <input type="submit" value="Submit" id="submitPost">
                    <div class="clearFix"></div>
                </div>
                    </form>
            </div> 
            
            <div id="error">
            </div>
            
            <div id="placehold">
                Recommended toasters<hr></hr>
                <?php require('php/recommendToaster.php'); ?>
            </div>
        </div>
    </div>

	<script src="js/formPost.js"></script>
</body>
</html>