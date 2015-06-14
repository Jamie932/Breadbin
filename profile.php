<?php 
    include 'php/init.php';
?>
<html>
<head>
    <title>Bread Bin</title>
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/jquery.cookie.js"></script>
    <script src="js/checkLogin.js"></script>
</head>
<body class="profile">
    <div id="navbar">
        <div class="left">
            <a href="main.php" class="navLinks">Bread Bin</a>
        </div>
        <div class="right">
            <ul class="nav">
                
            <li class="nav">
                <a class="navLinks" href="settings.php" >Profile</a>
            </li>

            </ul>
            
        </div>
    </div>
       
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
                <div class="userPostedImg">
                    <img src="img/cat.jpg" height="640px" width="640px"> 
                </div>
                <div class="userPostedLike">
                    <P>Toast</P>
                    <P>Burn</P>
                    <P class="report">Report</P>
                </div>
            </div>
            <div class="profilePosts">
                <div class="userPostedImg">
                    <img src="img/cat.jpg" height="640px" width="640px"> 
                </div>
                <div class="userPostedLike">
                    <P>Toast</P>
                    <P>Burn</P>
                    <P class="report">Report</P>
                </div>
            </div>
            <div class="profilePosts">
                <div class="userPostedImg">
                    <img src="img/cat.jpg" height="640px" width="640px"> 
                </div>
                <div class="userPostedLike">
                    <P>Toast</P>
                    <P>Burn</P>
                    <P class="report">Report</P>
                </div>
            </div>
        </div>

	</body>
</html>
