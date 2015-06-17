<?php 
    require("php/common.php");
    require("php/checkLogin.php");
    
    if (empty($_GET)) {
        if ($_SESSION['user']['id']) {
            header('Location: profile.php?id=' .$_SESSION['user']['id'] );
            die();
        }
    } else {

        $query = "SELECT * FROM users WHERE id = :id"; 
        $query_params = array(':id' => intval($_GET['id'])); 
        
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
        $row = $stmt->fetch();

        if($row){ 
            $userid = $row['id'];
            $usersname = $row['username'];
            $email = $row['email'];
        }
    }
?>
<html>
<head>
    <title><?php print (isset($usersname) ? $usersname : 'Unknown') ?> | Breadbin</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/profile.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lato:300,700' rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/jquery.cookie.js"></script>
    <script>
        $(document).ready(function(){
            function getUrlParameter(sParam) {
                var sPageURL = window.location.search.substring(1);
                var sURLVariables = sPageURL.split('&');
                
                for (var i = 0; i < sURLVariables.length; i++) {   
                    var sParameterName = sURLVariables[i].split('=');
                    if (sParameterName[0] == sParam) {
                        return sParameterName[1];
                    }
                }
            }        
            
            $( "#followBut" ).click(function() {
                var formData = {
                    'url' : getUrlParameter('id')
                };

                $.ajax({
                    type        : 'POST',
                    url         : 'php/follow.php',
                    data        : formData,
                    dataType    : 'json',
                    encode      : true
                })
            })
            
        });
        
    </script>
</head>
    
<body class="profile">
    <noscript>
      <META HTTP-EQUIV="Refresh" CONTENT="0;URL=error.php">
    </noscript>    
        
    <?php require('php/template/navbar.php');?>
    <div id="profileContainer">
        <div id="leftProfile">
            <div id="userAvatar">
            </div>

            <div class="userInfo">            
                <?php 
                    if (isset($usersname)) {
                        echo '<div class="nameRow">' . $usersname . '</div>';
                        echo '<div class="locationRow">United Kingdom</div>';
                        echo '<div class="bioRow">NVno7ns5Vcw7AvltnzZrwVHk88iM1iBfe8J6UJGIT7CroyOsBBnionfeaBP3WJWYKigIxYwSAQNif9JODRsHjYwoGezoljjcsiBCkxzqzBG80XfuUweYx3nJfGtpjU6clZJ9nDSQay1N</div>';
                        echo '<div class="followerRow">';
                            echo '<div class="followerLeft">';
                                echo '<div class="followerTitle">Followers</div>';
                                echo '<div class="followerContent">12</div>';
                            echo '</div>';
                            echo '<div class="followerRight">';
                                echo '<div class="followerTitle">Followed</div>';
                                echo '<div class="followerContent">14</div>';
                            echo '</div>';
                        echo '</div>';
                    } else {
                        echo '<div id="errormsg">User not found</div>';
                    }
                ?>
            </div>

            <?php 
                if (isset($usersname)) {
                    if (($userid != $_SESSION['user']['id'])) { ?>
                        <div class="bottomRow">
                            <button id="followBut">Follow</button>
                            <button id="messageBut">Message</button>
                            <button id="reportBut">Report</button>
                        </div>
            <?php } else { ?>
                        <div class="bottomRow">
                            <a href="settings/accountSettings.php"><button id="settingsBut">Settings</button></a>
                        </div>
            <?php }} ?>
        </div>
        
        <div id="rightProfile">
            <div class="grid">
            <?php
	               require("php/timeago.php");
                    $count = 0;
                    $query = "SELECT * FROM posts WHERE userid = :id ORDER BY date DESC";  
                    $query_params = array(':id' => $userid); 

                    $stmt = $db->prepare($query); 
                    $result = $stmt->execute($query_params); 
                    $posts = $stmt->fetchAll();
 
                    foreach ($posts as $row) {                            
                        if ($backwards) {
                            if ($count % 2 == 0) { //even
                                echo '<div class="grid-item grid-item-large" style="float: left;">';
                                    echo '<span class="floatLeft">' . $row['text'] . '</span>';
                                    echo '<span class="floatRight">' . timeAgoInWords($row['date']) . '</span>';
                                echo '</div>';
                            } else {
                                echo '<div class="grid-item" style="float: left; margin-left:20px">';
                                    echo '<span class="floatLeft">' . $row['text'] . '</span>';
                                    echo '<span class="floatRight">' . timeAgoInWords($row['date']) . '</span>';
                                echo '</div><div class="clearFix"></div>';
                                $backwards = false;
                            }
                        } else {
                            if ($count % 2 == 0) { //even
                                echo '<div class="grid-item" style="float: left;">';
                                    echo '<span class="floatLeft">' . $row['text'] . '</span>';
                                    echo '<span class="floatRight">' . timeAgoInWords($row['date']) . '</span>';
                                echo '</div>';
                            } else {
                                echo '<div class="grid-item grid-item-large" style="float: left; margin-left:20px">';
                                    echo '<span class="floatLeft">' . $row['text'] . '</span>';
                                    echo '<span class="floatRight">' . timeAgoInWords($row['date']) . '</span>';
                                echo '</div><div class="clearFix"></div>';
                                $backwards = true;
                            }
                        }
                        
                        $count++;
                    }
                ?>
            </div>
        </div>
        <div class="clearFix"></div>
    </div>
</body>
</html>