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
            <ul class="settingsList">
                <li class="settingsListFirst">
                    Account Settings
                </li>
                <li class="settingsList">
                    Privacy
                </li>
                <li class="settingsList">
                    Privacy
                </li>
                <li class="settingsList">
                    Privacy
                </li>
                <li class="settingsList">
                    Privacy
                </li>
                <li class="settingsList">
                    Privacy
                </li>
                <li class="settingsListLast">
                    Privacy
                </li>
            </ul>
        </div>
        
        <div class="rightSettings">
            <div class="settingsField">
                <h3 class="settings">Account Settings</h3>
                <form action="php/ProfileUpdate.php" method="post">
                    <label>First name: </label>
                        <input type="text" name="firstname" class="settings">
                        <br>
                        <br>
                    <label>Last name: </label>
                        <input type="text" name="lastname" class="settings">
                        <br>
                        <br>
                    <label>Email: </label>
                        <input type="text" name="email" class="settings">
                        <br>
                        <br>
                   <label> Colour: </label>
                        <input type="text" name="colour" class="settings">
                        <br>
                        <br>
                        <input type="submit" value="Save">
                </form>
            </div>
        </div>
    </div>
</body>
</html>