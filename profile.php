<?php include 'php/init.php'; ?>
<html>
<head>
    <title>Bread Bin</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/jquery.cookie.js"></script>
    <script src="js/brickwall.js"></script>
    <script type="text/javascript">
			$(function() {
				$('ul img').each(function(i, element) {
					var focusY = Math.floor((Math.random()*4)+1);
					var focusX = Math.floor((Math.random()*4)+1);
					$(element).attr({'focus-y': focusY, 'focus-x': focusX});
				});
				$('ul').brickwall();
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
                require("php/common.php"); 
                $userID = intval($_GET['id']);
                $query = "SELECT * FROM users WHERE id = :id"; 
                $query_params = array(':id' => $userID); 

                try{ 
                    $stmt = $db->prepare($query); 
                    $result = $stmt->execute($query_params); 
                } 
                catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
                $row = $stmt->fetch();

                if($row){ 
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
            <?php 
                require("php/common.php"); 
                $userID = intval($_GET['id']);
                $query = "SELECT * FROM posts ORDER BY date DESC";  
                $query_params = array(':id' => $userID); 

                try{ 
                    $stmt = $db->prepare($query); 
                    $result = $stmt->execute($query_params); 
                } 
                catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
                    $posts = $stmt->fetchAll();
 
                foreach ($posts as $row) {
                    echo $row['text'];
                }

            ?>
        </div>
    </div>
</body>
</html>
