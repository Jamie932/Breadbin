<?php
    require("php/common.php");
    require("php/checkLogin.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Settings | Breadbin</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/common.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/profile.css" rel="stylesheet" type="text/css">
    <link href="css/settings.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="js/vendor/jquery-1.11.2.min.js"></script>
    <script src="js/vendor/jquery.cookie.js"></script>
    <script src="js/vendor/jquery.color.js"></script>
    <script src="js/pages/settings.js"></script>
    <script src="js/vendor/progressbar.min.js"></script>
</head>
    
<body>
    <div id="blackOverlay"></div>
    <noscript>
      <META HTTP-EQUIV="Refresh" CONTENT="0;URL=error.php">
    </noscript>    
        
    <?php require('php/template/navbar.php'); ?>
        
    <div id="profileContainer">
       <?php require('php/template/profileLeft.php'); ?>
        
        <div id="rightSettings">
            <div id="settingsContainer">
                <div class="leftSettings noselect">
                    <ul class="settingsList">
                        <?php
                            if (isset($colour)) {
                                echo '<li class="leftHeader" style="background-color: '. $colour . '">User Settings</li>';
                            } else {
                                echo '<li class="leftHeader">User Settings</li>';
                            }
                            ?>
                        <li class="settingsList accountdetails active">Account Details</li>                    
                        <li class="settingsList privacy">Privacy</li>
                        <li class="settingsList passwordreset">Password Reset</li>
                        <li class="settingsList deleteaccount">Delete Account</li>
                    </ul>
                </div>
                
                <div id="boxContainer">
                    <div id="accountdetailsBox" class="settingsBox">
                        <div class="rightSettings">
                            <div class="container">
                                <div class="settingsHeader"><h3 class="settings">Account Details</h3></div>

                                <form action="php/SettingsUpdate.php" method="post" id="detailsForm" >
                                    <div class="rowContainer">
                                        <label>First Name: </label>
                                        <input type="text" name="firstname" class="settings" id="setFirstname" value="<?php echo $firstname;?>">
                                    </div>

                                      <div class="rowContainer">
                                        <label>Last Name: </label>
                                        <input type="text" name="lastname" class="settings" id="setLastname" value="<?php echo $lastname;?>">
                                    </div>                              

                                    <div class="rowContainer">
                                        <label>Email: </label>
                                        <input type="text" name="email" class="settings" id="setEmail" value="<?php echo $email; ?>">
                                    </div>

                                    <div class="rowContainer">
                                       <label> Colour: </label>
                                        <div id="colourContainer">
                                            <div class="colourBox orange"></div>
                                            <div class="colourBox blue"></div>
                                            <div class="colourBox green"></div>
                                            <div class="colourBox red"></div>
                                            <div class="colourBox purple"></div>
                                            <div class="colourBox pink"></div>
                                        </div>
                                        <!--<select name="colour" class="settings" id="setColour">
                                            <option value="1">Orange</option>
                                            <option value="2">Blue</option>
                                            <option value="3">Green</option>
                                            <option value="4">Red</option>
                                            <option value="5">Purple</option>
                                            <option value="6">Pink</option>
                                        </select>-->
                                    </div>

                                    <input type="submit" value="Save" class="saveSettings">
                                </form>
                            </div>
                        </div>
                    </div> 

                    <div id="privacyBox" class="settingsBox">
                        <div class="rightSettings">
                            <div class="container">
                                <div class="settingsHeader"><h3 class="settings">Privacy</h3></div>

                                <form action="php/SettingsUpdate.php" method="post">
                                    <div class="rowContainer">
                                        <label>First Name: </label>
                                        <input type="text" name="firstname" class="settings" id="setFirstname" value="<?php echo $firstname;?>">
                                    </div>

                                      <div class="rowContainer">
                                        <label>Last Name: </label>
                                        <input type="text" name="lastname" class="settings" id="setLastname" value="<?php echo $lastname;?>">
                                    </div>                              

                                    <div class="rowContainer">
                                        <label>Email: </label>
                                        <input type="text" name="email" class="settings" id="setEmail" value="<?php echo $email; ?>">
                                    </div>

                                    <div class="rowContainer">
                                       <label> Colour: </label>
                                        <select name="colour" class="settings" id="setColour">
                                            <option value="1" style="background:#8AE68A">Green</option>
                                            <option value="2" style="background:#6699FF">Blue</option>
                                            <option value="3" style="background:#FFB540">Orange</option>
                                            <option value="4" style="background:#FF66CC">Pink</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> 

                     <div id="passwordresetBox" class="settingsBox">
                        <div class="rightSettings">
                            <div class="container">
                                <div class="settingsHeader"><h3 class="settings">Password Reset</h3></div>

                                <form action="php/passwordUpdate.php" method="post">
                                    <div class="rowContainer">
                                        <label>Current Password: </label>
                                        <input type="password" name="currentPassword" class="settings" id="currentPassword">
                                    </div>

                                      <div class="rowContainer">
                                        <label>New Password: </label>
                                        <input type="password" name="newPassword" class="settings" id="newPassword">
                                    </div>                              

                                    <div class="rowContainer">
                                        <label>Verify Password: </label>
                                        <input type="password" name="newPassword2" class="settings" id="newPassword2">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>    

                     <div id="deleteaccountBox" class="settingsBox">
                        <div class="rightSettings">
                            <div class="container">
                                <div class="settingsHeader"><h3 class="settings">Delete Account</h3></div>

                                <form action="php/SettingsUpdate.php" method="post">
                                    <div class="rowContainer">
                                        <p class="innerContent">WARNING: Deleting your account will completely remove ALL content associated with it.
                                        There is no way back, so please be careful with this option.</p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> 
                </div>
                
                <div class="clearFix"></div>
            </div>
        </div>     
        
        <form id="avatarForm" method="POST" enctype="multipart/form-data">
            <div style='height: 0px;width:0px; overflow:hidden;'><input id="upfile" type="file" value="upfile" accept="image/*" onchange="submitAvatar()"/></div>
        </form>
    </div>    
</body>
</html>