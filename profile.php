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
            
            if ($row['bio']) {
                $bio = $row['bio'];
            }
            
            if ($row['country']) {
                $country = $row['country'];
            }
        }
        
        $query = "SELECT count(*) FROM following WHERE user_no = :id"; 
        $query_params = array(':id' => intval($_GET['id'])); 
        
        $result = $db->prepare($query); 
        $result->execute($query_params); 
        $noOfFollowers = $result->fetchColumn(); 
        
        $query = "SELECT count(*) FROM following WHERE follower_id = :id"; 
        $query_params = array(':id' => intval($_GET['id'])); 
        
        $result = $db->prepare($query); 
        $result->execute($query_params); 
        $noOfFollowing = $result->fetchColumn(); 
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
            
            $(document).on('click','#followBut', function() { 
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

                $('.followers').html(parseInt($('.followers').text()) + 1);
                $('#followBut').replaceWith('<button id="unFollowBut">Unfollow</button>');   
            })
            
            $(document).on('click','#unFollowBut', function() {
                var formData = {
                    'url' : getUrlParameter('id')
                };

                $.ajax({
                    type        : 'POST',
                    url         : 'php/unfollow.php',
                    data        : formData,
                    dataType    : 'json',
                    encode      : true
                })

                $('.followers').html(parseInt($('.followers').text()) - 1);
                $('#unFollowBut').replaceWith('<button id="followBut">Follow</button>');
            })
            
            $(".settingsBut").click(function(){
               $(".settingsBut").fadeOut('normal')
               $("#rightProfile").fadeOut('normal', function(){
                    $("#settingsBox").fadeIn('normal');
                    $(".backBut").fadeIn('normal');
                    $(".leftSettings").animate({ 'marginLeft': '0px' }, 350);
                });
            });
            
            $(".backBut").click(function(){
               $(".backBut").fadeOut('normal');
               $(".leftSettings").animate({ 'marginLeft': '-140px' }, 350);
               $("#settingsBox").fadeOut('normal', function(){
                    $("#rightProfile").fadeIn('normal');
                    $(".settingsBut").fadeIn('normal');
                });
            });
            
            $(".passwordReset").click(function(){
                $(".accountSettingsField").fadeOut('normal', function(){
                    $(".passwordSettingsField").fadeIn('normal');
                    });
                });
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
                        echo '<div class="locationRow">' . (isset($country) ? $country : "Earth") . '</div>';
                        echo '<div class="bioRow">' . (isset($bio) ? $bio : "") . '</div>';
                        echo '<div class="followerRow">';
                            echo '<div class="followerLeft">';
                                echo '<div class="followerTitle">Following</div>';
                                echo '<div class="followerContent following">' .$noOfFollowing . '</div>';
                            echo '</div>';
                            echo '<div class="followerRight">';
                                echo '<div class="followerTitle">Followers</div>';
                                echo '<div class="followerContent followers">'. $noOfFollowers . '</div>';
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
                            <?php
                                $query = "SELECT * FROM following WHERE follower_id = :id AND user_no = :userid"; 
                                $query_params = array(':id' => $_SESSION['user']['id'], ':userid' => $_GET['id']);
                                
                                $stmt = $db->prepare($query); 
                                $result = $stmt->execute($query_params); 
                                $row = $stmt->fetch();
                                    
                                if ($row['user_no'] != intval($_GET['id'])) {
                                       echo '<button id="followBut">Follow</button>';
                                } else {
                                        echo '<button id="unFollowBut">Unfollow</button>';   
                                }                                
                            ?>
                            <button id="messageBut">Message</button>
                            <button id="reportBut">Report</button>
                        </div>
            <?php } else { ?>
                        <div class="bottomRow">
                            <button class="settingsBut">Settings</button>
                            <button class="backBut">Back</button>
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
                            if ($row['type'] == "image") {
                                echo '<img class="imgPost" src="' . $row['image'] . '">';  
                                echo '</div>';
                            } else if ($row['type'] == "text") {
                                echo '<p class="textPost">' . $row['text'] . '</p>';
                                echo '</div>';
                            }
                    }  
                ?>
            </div>
        </div>
        
        <div id="clearFix"></div>
        
        <div id="rightSettings">
            <div class="leftSettings">
                <ul class="settingsList">
                    <li class="settingsListFirst">
                        Account Details
                    </li>
                <a href="privacySettings.php" class="settingsLinks">
                    <li class="settingsList">
                        Privacy
                    </li>
                </a>
                    <li class="settingsList">
                        Privacy
                    </li>
                    <li class="settingsList">
                        Privacy
                    </li>
                    <li class="settingsList">
                        Privacy
                    </li>
                    <a class="passwordReset">
                    <li class="settingsList">
                        Password reset
                    </li>
                    </a>
                    <li class="settingsListLast">
                        Delete account
                    </li>
                </ul>
            </div>
            
    <div id="settingsBox" style="height:500px;">
        <div class="rightSettings">
            <div class="accountSettingsField">
                <div class="settingsHeader">
                    <h3 class="settings">Account Details</h3>
                    <p class="settingsDetail">Update your account details</p>
                </div>
                <form action="../php/SettingsUpdate.php" method="post" class="accountSettings">
                    <label>First name: </label>
                        <input type="text" name="firstname" class="settings" id="setFirstname" value="<?php echo $firstname ?>">
                        <br>
                        <br>
                    <label>Last name: </label>
                        <input type="text" name="lastname" class="settings" id="setLastname" value="<?php echo $lastname ?>">
                        <br>
                        <br>
                    <label>Email: </label>
                        <input type="text" name="email" class="settings" id="setEmail" value="<?php echo $email ?>">
                        <br>
                        <br>
                   <label> Colour: </label>
                        <select name="colour" class="settings" id="setColour">
                            <option value="1" style="background:#8AE68A">Green</option>
                            <option value="2" style="background:#6699FF">Blue</option>
                            <option value="3" style="background:#FFB540">Orange</option>
                            <option value="4" style="background:#FF66CC">Pink</option>
                        </select>
                        <br>
                        <br>
                    <label> </label>
                        
                        <input type="submit" value="Save" class="saveSettings">
                </form>
            </div>
            
            <div class="passwordSettingsField">
                <div class="settingsHeader">
                    <h3 class="settings">Reset your password</h3>
                    <p class="settingsDetail"></p>
                </div>
                <form action="../php/passwordUpdate.php" method="post" class="accountSettings">
                    <label>Current Password: </label>
                        <input type="password" name="currentPassword" class="settings" id="currentPassword">
                        <br>
                        <br>
                    <label>New password: </label>
                        <input type="password" name="newPassword" class="settings" id="newPassword">
                        <br>
                        <br>
                    <label>Verify password: </label>
                        <input type="password" name="newPassword2" class="settings" id="newPassword2">
                        <br>
                        <br>
                        
                        <input type="submit" value="Save" class="saveSettings">
                </form>
            </div>
        </div>

    </div>
    <script src="../js/formSettings.js"></script>
        
        
        
        
        
        
        
        
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