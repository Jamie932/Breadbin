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
    <link href='http://fonts.googleapis.com/css?family=Lato:400,700%7CRoboto:400,700' rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/jquery.cookie.js"></script>
    <script type="text/javascript" src="js/freewall.js"></script>
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
            <div class="free-wall">
            <?php
                    $query = "SELECT * FROM posts WHERE userid = :id ORDER BY date DESC";  
                    $query_params = array(':id' => $userid); 

                    $stmt = $db->prepare($query); 
                    $result = $stmt->execute($query_params); 
                    $posts = $stmt->fetchAll();
 
                    foreach ($posts as $row) {   
                        echo '<div class="brick size320">';
                            echo '<p class="textPost">' . $row['text'] . '</p>';
                        echo '</div>';
                    } 
                ?>
            </div>
        </div>
        <div class="clearFix"></div>
    </div>
        
<script type="text/javascript">
	var colour = [
		"rgb(138, 230, 138)",
		"rgb(102, 153, 255)",
		"rgb(255, 181, 64)",
		"rgb(255, 102, 204)"
	];
	
	$(".free-wall .size320").each(function() {
		var backgroundColor = colour[colour.length * Math.random() << 0];
		var bricks = $(this).find(".brick");
		!bricks.length && (bricks = $(this));
		bricks.css({
			backgroundColor: backgroundColor
		});
	});

	$(function() {
		$(".free-wall").each(function() {
			var wall = new freewall(this);
			wall.reset({
				selector: '.size320',
				cellW: function(container) {
					var cellWidth = 320;
					if (container.hasClass('size320')) {
						cellWidth = container.width()/2;
					}
					return cellWidth;
				},
				cellH: function(container) {
					var cellHeight = 220;
					if (container.hasClass('size320')) {
						cellHeight = container.height()/2;
					}
					return cellHeight;
				},
				fixSize: 0,
				gutterY: 20,
				gutterX: 20,
				onResize: function() {
					wall.fitWidth();
				}
			})
			wall.fitWidth();
		});
		$(window).trigger("resize");
	});
</script>
</body>
</html>