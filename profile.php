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
        $username = $row['username'];
        $email = $row['email'];
    }
?>
<html>
<head>
    <title>Breadbin - User: <?php print (isset($username) ? $username : 'Unknown')></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/jquery.cookie.js"></script>
    <script src="js/brickwall.js"></script>
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
        <div class="userInfo">
            <?php 
                if ($username) {
                    echo 'User ID: ' . $row['id'] . '<br>';
                    echo 'Username: ' . $row['username'] . '<br>';
                    echo 'Email: ' . $row['email'];
                } else {
                    echo "<div id=\"errormsg\"> User not found </div>";
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