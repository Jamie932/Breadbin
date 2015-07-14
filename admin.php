<?php 
    require("php/common.php");
    require("php/checkLogin.php");
    require("php/checkRank.php");

    $query = "SELECT COUNT(*) FROM posts WHERE date > DATE_SUB(now(), INTERVAL 1 DAY)"; 
    $stmt = $db->prepare($query); 
    $result = $stmt->execute(); 
    $row = $stmt->fetch();

    $numPosts = $row[0];

    $query = "SELECT COUNT(*) FROM post_toasts WHERE date > DATE_SUB(now(), INTERVAL 1 DAY)"; 
    $stmt = $db->prepare($query); 
    $result = $stmt->execute(); 
    $row = $stmt->fetch();

    $numToasts = $row[0];

    $query = "SELECT COUNT(*) FROM post_burns WHERE date > DATE_SUB(now(), INTERVAL 1 DAY)"; 
    $stmt = $db->prepare($query); 
    $result = $stmt->execute(); 
    $row = $stmt->fetch();

    $numBurns = $row[0];

    $query = "SELECT COUNT(*) FROM users WHERE date > DATE_SUB(now(), INTERVAL 1 DAY)"; 
    $stmt = $db->prepare($query); 
    $result = $stmt->execute(); 
    $row = $stmt->fetch();

    $numUsers = $row[0];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Breadbin - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="css/common.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/admin.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/chartist.min.css">
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="js/vendor/jquery-1.11.2.min.js"></script>
    <script src="js/vendor/jquery.cookie.js"></script>
    <script src="js/errorHandler.js" async></script>
    <script src="js/vendor/chartist.min.js"></script>
</head>
<body>
    <noscript>
      <META HTTP-EQUIV="Refresh" CONTENT="0;URL=error.php">
    </noscript>    
    
    <?php require('php/template/navbar.php');?>
    <?php require('php/template/popup.php');?>
        
    <div id="contentWrap">
        <div id="topBar">
            <div class="contentContainer">
                <div class="content">
                    <div class="statNumber"><?php echo $numPosts; ?></div>
                    <div class="statBottom">Posts</div>
                </div>   
                <div class="content">
                    <div class="statNumber"><?php echo $numToasts; ?></div>
                    <div class="statBottom">Toasts</div>
                </div>   
                <div class="content">
                    <div class="statNumber"><?php echo $numBurns; ?></div>
                    <div class="statBottom">Burns</div>
                </div>   
                <div class="content">
                    <div class="statNumber">0</div>
                    <div class="statBottom">Reports</div>
                </div>   
                <div class="content">
                    <div class="statNumber"><?php echo numUsers; ?></div>
                    <div class="statBottom">New Users</div>
                </div>  
            </div>

            <div id="bottomTopBar"><div class="content">24hr | 48hr | 1wk</div></div>
        </div>

        <div id="midContainer">
            <div id="midLeft"><div class="title">Unique Visitors</div><div class="ct-chart ct-octave"></div></div>
            <div id="midRight"><div class="title">Reports</div></div>
        </div>
    </div>
        
    <script>
        var data = {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
            series: [
                [5, 2, 4, 2, 0]
            ]
        };

        new Chartist.Line('.ct-chart', data);

    </script>        
</body>
</html>