<?php 
    include('php/init.php');
    require("php/checkLogin.php");
    require("php/common.php"); 
    $query = "SELECT * FROM users WHERE id = :id"; 
    $query_params = array(':id' => intval($_GET['id'])); 

    try{ 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
    } 
    catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
    $row = $stmt->fetch();

    if($row){ 
        $userid = $row['id'];
        $usersname = $row['username'];
        $email = $row['email'];
    }
?>
<html>
<head>
    <title>Breadbin - User: <?php print (isset($usersname) ? $usersname : 'Unknown') ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/jquery.cookie.js"></script>
    <script src="js/brickwall.js"></script>
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
    <script type="text/javascript">
			$(function() {
				$('ul.post img').each(function(i, element) {
					var focusY = Math.floor((Math.random()*4)+1);
					var focusX = Math.floor((Math.random()*4)+1);
					$(element).attr({'focus-y': focusY, 'focus-x': focusX});
				});
				$('ul.post').brickwall();
			});
    </script>
</head>
    
<body class="profile">
    <noscript>
      <META HTTP-EQUIV="Refresh" CONTENT="0;URL=error.php">
    </noscript>    
        
    <?php require('php/template/navbar.php');?>
       
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
                    echo '</div>';
                    
                    echo '<div class="bottomRow">';
                        echo '<button id="followBut">Follow</button>';
                        echo '<button id="followBut">Message</button>';
                        echo '<button id="followBut">Report</button>;';
                    echo '</div>';	
                    
                } else {
                    echo '<div id="errormsg">User not found</div>';
                }
            ?>
        </div>
    </div>
    
    <div id="rightProfile">
        <div class="profilePosts">
            <ul class="post">
            <?php 
                require("php/common.php"); 
                $userID = intval($_GET['id']);
                $query = "SELECT * FROM posts WHERE userid = :id ORDER BY date DESC";  
                $query_params = array(':id' => $userID); 

                try{ 
                    $stmt = $db->prepare($query); 
                    $result = $stmt->execute($query_params); 
                } 
                catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
                    $posts = $stmt->fetchAll();
 
                foreach ($posts as $row) {
                    echo '<li>';
                    echo '<div class="thumbnail">';
                    echo '<a class="profilePosts" href="" title="">';?>
                     <script>
                        function random_imglink(){
                            var myimages=new Array()
                            myimages[1]="img/greenFill.jpg"
                            myimages[2]="img/blueFill.jpg"
                            myimages[3]="img/orangeFill.jpg"
                            myimages[4]="img/pinkFill.jpg"

                            var ry=Math.floor(Math.random()*myimages.length)
                            if (ry==0)
                            ry=1
                            document.write('<img src="'+myimages[ry]+'" border=0 width="600" height="150" focus-y="3" focus-x="3">')
                        }
                        random_imglink()
                    </script>
                <?php
                    echo '<div class="textOverlay">' . $row['text'] . '</div>';
                    echo '</a>';
                    echo '</div>';
                    echo '</li>';
                }
            ?>
            </ul>
        </div>
    </div>
</body>
</html>