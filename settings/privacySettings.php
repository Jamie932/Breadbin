<?php 
    require("php/common.php"); 
?>
<html>
<head>
    <title>Bread Bin</title>
    <link href="../css/main.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <script src="../js/jquery-1.11.2.min.js"></script>
    <script src="../js/jquery.cookie.js"></script>
</head>
    
<body>
    <?php require('../php/template/settingsNavbar.php');?>
    
    <div id="settingsBox" style="height:500px;">
        <div class="leftSettings">
            <ul class="settingsList">
            <a href="accountSettings.php" class="settingsLinks">
                <li class="settingsList">
                    Account Details
                </li>
            </a>
                <li class="settingsListFirst">
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
                <div class="settingsHeader">
                    <h3 class="settings">Privacy Settings</h3>
                    <p class="settingsDetail">Keep your account and data safe</p>
                </div>
                <form action="" method="post" class="accountSettings">
                        
                        <input type="submit" value="Save" class="saveSettings">
                </form>
            </div>
        </div>
    </div>
</body>
</html>