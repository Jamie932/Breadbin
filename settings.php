<?php
    require("php/common.php");
    require("php/checkLogin.php");

    $query        = "SELECT * FROM users WHERE id = :id";
    $query_params = array(':id' => $_SESSION['user']['id']);
    
    $stmt   = $db->prepare($query);
    $result = $stmt->execute($query_params);
    $row    = $stmt->fetch();
    
    if ($row) {
        $userid    = $row['id'];
        $usersname = $row['username'];
        $email     = $row['email'];
        $firstname     = $row['firstname'];
        $lastname     = $row['lastname'];
        
        if ($row['bio']) {
            $bio = $row['bio'];
        }
        
        if ($row['country']) {
            $country = $row['country'];
        }
    }
    
    $query        = "SELECT count(*) FROM following WHERE user_no = :id";
    $query_params = array(':id' => $_SESSION['user']['id']);
    
    $result = $db->prepare($query);
    $result->execute($query_params);
    $noOfFollowers = $result->fetchColumn();
    
    $query        = "SELECT count(*) FROM following WHERE follower_id = :id";
    $query_params = array(':id' =>  $_SESSION['user']['id']);
    
    $result = $db->prepare($query);
    $result->execute($query_params);
    $noOfFollowing = $result->fetchColumn();
?>
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
    <script async>
        var uploadingFile = false;
        
        $(document).ready(function(){
            $(".passwordReset").click(function(){
                $(".accountSettingsField").fadeOut('normal', function(){
                    $(".passwordSettingsField").fadeIn('normal');
                });
            });
            
            var lastBio = "";
            var editing = false;
            
            $("#avatarOverlay").click(function(){
                if ($('.bioRow').attr("contentEditable") != "true") {
                    $('.bioRow').attr('contenteditable','true');
                    $('.bioRow').addClass('editableContent');
                    $('#userAvatar').addClass('editableContent');
                    
                    $('#blackOverlay').fadeIn('normal');
                    $('#leftProfile').animate({backgroundColor:'#7B7B7B'}, 400);
                    $('.saveBut').fadeIn('normal');
                    
                    lastBio = $('.bioRow').text();
                    editing  = true;
                }
            });   
            
            $(document).on('click','.saveBut', function() {
                if (lastBio != $('.bioRow').text()) {
                    var confirmed = confirm("Would you like to save these changes?");

                    if (confirmed) {
                        var formData = {
                            'content' : $('.bioRow').text()
                        };

                        $.ajax({
                            type        : 'POST',
                            url         : 'php/updateBio.php',
                            data        : formData,
                            dataType    : 'json',
                            encode      : true
                        })
                    } else {
                        $('.bioRow').text(lastBio);   
                    }
                }
                
                $('.bioRow').attr('contenteditable','false');
                $('.bioRow').removeClass('editableContent');
                $('#userAvatar').removeClass('editableContent');
                $('#blackOverlay').fadeOut('normal');
                $('#leftProfile').animate({backgroundColor:'#FFF'}, 400);
                $('.saveBut').fadeOut('normal');
                editing = false;
            });
            
            $(window).bind("beforeunload", function(event) {
               if (editing && (lastBio != $('.bioRow').text())) return "You have unsaved changes"; 
            });
            
            $('.bioRow').keypress(function(e) {
                return e.which != 13;
            });
            
            $('.bioRow').keydown(function(e){ 
                if (e.which != 8 && $('.bioRow').text().length > 140) {
                    createError("You have reached the 140 character limit."); 
                    e.preventDefault();
                }    
            });
            
            $('.bioRow').bind("cut copy paste",function(e) {
              e.preventDefault();
            });
            
            $(document).on('click','#userAvatar', function() {
                if (editing) {
                    if (!uploadingFile) {
                        $('#upfile').click();
                    }
                }
            });
            
            $("#upfile").change(function (){
                uploadingFile = true;
            });
            
            $('li.settingsList').click(function() {
                if ($(this).hasClass('accountdetails')) {
                    $('.settingsBox').fadeOut('normal').promise().done(function() { $('#accountdetailsBox').fadeIn('normal'); });
                } else if ($(this).hasClass('privacy')) {
                    $('.settingsBox').fadeOut('normal').promise().done(function() { $('#privacyBox').fadeIn('normal'); });
                } else if ($(this).hasClass('passwordreset')) {
                    $('.settingsBox').fadeOut('normal').promise().done(function() { $('#passwordresetBox').fadeIn('normal'); });
                } else if ($(this).hasClass('deleteaccount')) {
                    $('.settingsBox').fadeOut('normal').promise().done(function() { $('#deleteaccountBox').fadeIn('normal'); });
                }
            });
        });
        
        $(window).scroll(function() {
            $('.leftSettings').css('marginLeft', -$(window).scrollLeft()); 
        });        
    </script>
    <script src="js/vendor/progressbar.min.js" async></script>
    <script src="js/formChangeAvatar.js" async></script>
    <script src="js/formSettings.js" async></script>
</head>
    
<body class="profile">
    <div id="blackOverlay"></div>
    <noscript>
      <META HTTP-EQUIV="Refresh" CONTENT="0;URL=error.php">
    </noscript>    
        
    <?php require('php/template/navbar.php'); ?>
    <div id="profileContainer">
        <div id="leftProfile">
            <?php
                if (!file_exists('img/avatars/' . $_SESSION['user']['id'] . '/avatar.jpg')) {
                    echo '<div id="userAvatar"></div>';
                } else {
                    echo '<div id="userAvatar" style="background: url(img/avatars/' . $_SESSION['user']['id'] . '/avatar.jpg) no-repeat;"></div>';
                }

                echo '<div id="avatarOverlay"><img src="img/Inclined_Pencil_32.png" width="20" height="20"></div>';
            ?>
            
            <div class="userInfo">            
                <?php
                if (isset($usersname)) {
                    echo '<div class="nameRow">' . $usersname . '</div>';
                    echo '<div class="locationRow">' . (isset($country) ? $country : "Earth") . '</div>';
                    echo '<div class="bioRow">' . (isset($bio) ? $bio : "") . '</div>';
                    echo '<div class="followerRow">';
                    echo '<div class="followerLeft">';
                    echo '<div class="followerTitle">Following</div>';
                    echo '<div class="followerContent following">' . $noOfFollowing . '</div>';
                    echo '</div>';
                    echo '<div class="followerRight">';
                    echo '<div class="followerTitle">Followers</div>';
                    echo '<div class="followerContent followers">' . $noOfFollowers . '</div>';
                    echo '</div>';
                    echo '</div>';
                } else {
                    echo '<div id="errormsg">User not found</div>';
                }
                ?>
            </div>

            <div id="profileButtons">
                <div class="bottomRow">
                    <button class="saveBut buttonstyle" style="display: none;">Save</button>
                </div>
            </div>
        </div>
        
        <div id="rightSettings">
            <div id="settingsContainer">
                <div class="leftSettings noselect">
                    <ul class="settingsList">
                        <li class="leftHeader">User Settings</li>
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

                                    <input type="submit" value="Save" class="saveSettings">
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

                                    <input type="submit" value="Save" class="saveSettings">
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