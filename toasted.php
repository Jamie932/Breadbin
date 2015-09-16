<?php 
    require("php/common.php");
    require("php/checkLogin.php");

    $postsPerPage = 10;

    $query = 'SELECT COUNT(*) FROM posts'; 
    $stmt = $db->prepare($query); 
    $result = $stmt->execute(); 
    $numPosts = $stmt->fetchColumn();
    $numPages = ceil($numPosts / $postsPerPage);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Breadbin - Toasted</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="css/common.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href="css/vendor/lazyYT.css" rel="stylesheet" type="text/css">
    <link href="css/vendor/normalize.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="js/vendor/jquery-1.11.2.min.js"></script>
    <script src="js/vendor/jquery.cookie.js"></script>
    <script src="js/postFunctions.js" async></script>
    <script src="js/errorHandler.js" async></script>
    <script type="text/javascript" src="js/vendor/lazyYT.js"></script>
    <script>
        $( document ).ready(function() {
            $('.js-lazyYT').lazyYT(); 
        });
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
            <?php require('php/fetchToasted.php'); ?>
    </div> 
    </div> 
</body>
</html>