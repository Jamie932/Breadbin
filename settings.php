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
    
    <div id="settingsBox" style="height:500px;">
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
                <div class="settingsHeader">
                    <h3 class="settings">Account Settings</h3>
                    <p class="settingsDetail">Update your account details</p>
                </div>
                <form action="" method="post" clas="accountSettings">
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
                        <select class="settings">
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
        </div>
    </div>
</body>
</html>