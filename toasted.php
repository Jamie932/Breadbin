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
    <script async>
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
            <?php require('php/fetchToasted.php');?>
        </div>        
    </div>
</body>
</html>