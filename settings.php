<?php include 'php/init.php'; ?>
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
    <?php require('php/template/navbar.php');?>
    
    <div id="settingsBox">
        <div class="leftSettings">
            <div class="listStyle">
                <ul class="leftSettingsList">
                    <li>Test</li>
                    <li>Test</li>
                    <li>Test</li>
                </ul>
            </div>
        </div>
        
        <div class="rightSettings">
            <form action="php/ProfileUpdate.php" method="post">
                First name: 
                    <input type="text" name="firstname">
                Last name: 
                    <input type="text" name="lastname">
                Email: 
                    <input type="text" name="email">
                Colour: 
                    <input type="text" name="colour">
                    <input type="submit" value="Save">

            </form>
        </div>
    </div>
</body>
</html>