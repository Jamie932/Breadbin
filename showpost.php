<?php
require("php/common.php");
require("php/checkLogin.php");

if (empty($_GET)) {
    if ($_SESSION['user']['id']) {
        header('Location: main.php');
        die();
    }
    
} ?>

<html>
<head>
    <title>Post <?php echo $_GET['p'] ?> | Breadbin</title>
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
                        if (data.removedBurn && data.addedToast) { // Previously toasted
                            totalToasts.html(parseInt(totalToasts.text()) + 2);
                            
                            burnButton.css('color', 'black'); 
                            burnButton.toggleClass('unburn burn');
                        } else if (data.removedBurn || data.addedToast) {
                            totalToasts.html(parseInt(totalToasts.text()) + 1);
                        } else {
                            alert("problem detected woop woop");
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
                        alert("not successful soz");
                        
                    } else {
                        if (data.removedToast && data.addedBurn) { // Previously toasted
                            totalToasts.html(parseInt(totalToasts.text()) - 2);
                            
                            toastButton.css('color', 'black'); 
                            toastButton.toggleClass('untoast toast');
                        } else if (data.removedToast || data.addedBurn) {
                            totalToasts.html(parseInt(totalToasts.text()) - 1);
                        } else {
                            alert("problem detected woop woop");
                        }
                        
                        burnButton.css('color', 'darkgray'); 
                        burnButton.toggleClass('burn unburn');
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
            <?php
                $query = "SELECT * FROM posts WHERE id=:id";
                $query_params = array(':id' => $_GET['p']); 

                $stmt = $db->prepare($query); 
                $result = $stmt->execute($query_params); 

                $row = $stmt->fetch();

                echo '<div id="contentPost" class="post-' . $row['id'] . '">';
                    echo '<div class="contentPostText">' . $row['text'] . '</div>';
                    echo '<div id="contentInfoText">';
                        echo '<div class="left"><a href="profile.php?id=' . $row['userid'] . '">' . $username . '</a></div>';
                        echo '<div class="right">' . timeAgoInWords($row['date']) . '</div>';
                    echo '</div>';
                echo '</div>';

                if ($_SESSION['user']['id'] == $row['userid']) { 
                    echo '<div id="contentLike" class="post-' . $row['id'] . '">
                        <p class="delete">Delete</p>';
                        echo '<p class="totalToasts">' .$totalToasts. '</p></div><br>';
                } else {
                    echo '<div id="contentLike" class="post-' . $row['id'] . '">';

                    if ($ifToasted == 0) {
                        echo '<p class="toast">Toast</p>';
                    } else {
                        echo '<p class="untoast">Toast</p>';
                    } 
                    if ($ifBurnt == 0) {
                        echo '<p class="burn">Burn</p>';
                    } else {
                        echo '<p class="unburn">Burn</p>';
                    }
                    echo '<p class="report">Report</p>';
                    echo '<p class="totalToasts">' .$totalToasts. '</p></div><br>';  
                }
            ?>
        </div>
        
    </div>
</body>
</html>