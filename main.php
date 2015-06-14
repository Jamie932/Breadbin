<?php
   /* require("php/common.php");
    if(empty($_SESSION['user'])) 
    {
        header("Location: index.php");
        die("Redirecting to index.php"); 
    }*/
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
<body>
    <div id="navbar">
        <div class="left">
            <a href="settings.php" class="navLinks">Bread Bin</a>
        </div>
        <div class="right"
                
            <li>
                <a class="navLinks" href="profile.php" >Profile</a>
            </li>

            </ul>
            
        </div>
    </div>
    
    
    <div id="break"></div>
    
<div id="center">
    <div id="sidebar">
        <div class="upload">
            <div class="textarea">
                <form action="" id="upload">
                    <textarea name="TextUpload" id="uploadText" maxlength="150" placeholder="Have your say..."></textarea>
                </form>
            </div>
            <div class="uploadRest">
                <a><img src="img/cat.jpg" height="40px" width="40px"></a>
                <a><img src="img/cat.jpg" height="40px" width="40px"></a>
                <a><img src="img/cat.jpg" height="40px" width="40px"></a>
                <a><img src="img/cat.jpg" height="40px" width="40px"></a>
                <img src="img/cat.jpg" height="40px" width="60px" style="margin-left: 43px;">
            </div>
        </div>  
        <div id="placehold">
            <h5>Recommended toasters</h5>
            <div class="userRecom">
                <div class="usericoRecom">
                    <img src="img/cat.jpg" height="50px" width="50px">
                </div>
                   <div class="usernameRecom">
                        UsernameUsernameUser
                   </div>
            </div>
            <div class="userRecom">
                <div class="usericoRecom">
                    <img src="img/cat.jpg" height="50px" width="50px">
                </div>
                   <div class="usernameRecom">
                        UsernameUsernameUser
                   </div>
            </div>
            <div class="userRecom">
                <div class="usericoRecom">
                    <img src="img/cat.jpg" height="50px" width="50px">
                </div>
                   <div class="usernameRecom">
                        UsernameUsernameUser
                   </div>
            </div>
        </div>
    </div>
    
    <div id="content">
		<?php require('php/fetchPosts.php');?>
    </div>
</div>
</body>
</html>