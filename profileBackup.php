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
        <div id="rightProfile">
            <div class="free-wall">
                <div class="brick size320">
                    <img class="imgPost" src="img/a.jpg">
                </div>
                <div class="brick size320">
                    <img class="imgPost" src="img/t.gif">
                </div>
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