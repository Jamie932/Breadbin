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
            $('.delete').click(function() {      
                var confirmed = confirm("Are you sure you want to delete this post?");
      
                if (confirmed) {
                    $postid = $(this).parent().attr('class').split('-')[1];

                    var formData = {
                        'post' : $postid
                    };

                    $.ajax({
                        type        : 'POST',
                        url         : 'php/deletePost.php',
                        data        : formData,
                        dataType    : 'json',
                        encode      : true,
                       success:function(data) {                    
                           $("#contentPost .post-" . $postid).fadeOut('normal');
                            $(this).fadeOut('normal');
                       }
                    })
                }
            })
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
                    <a><img src="img/cat.jpg" height="40px" width="40px"></a>
                    <a><img src="img/cat.jpg" height="40px" width="40px"></a>
                    <a><img src="img/cat.jpg" height="40px" width="40px"></a>
                    <a><img src="img/cat.jpg" height="40px" width="40px"></a>
                    <input type="submit" value="Submit" id="submitPost">
                    <div class="clearFix"></div>
                </div>
                    </form>
            </div> 
            
            <div id="error">
            </div>
            
            <div id="placehold">
                <h5>Recommended toasters</h5>
                    <?php require('php/recommendToaster.php'); ?>
            </div>
        </div>
    </div>

	<script src="js/formPost.js"></script>
</body>
</html>