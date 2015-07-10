<?php
require("php/common.php");
require("php/checkLogin.php");

if (empty($_GET)) {
    if ($_SESSION['user']['id']) {
        header('Location: profile.php?id=' . $_SESSION['user']['id']);
        die();
    }
} else {
    
    $query        = "SELECT * FROM users WHERE id = :id";
    $query_params = array(':id' => intval($_GET['id']));
    
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
    $query_params = array(
        ':id' => intval($_GET['id'])
    );
    
    $result = $db->prepare($query);
    $result->execute($query_params);
    $noOfFollowers = $result->fetchColumn();
    
    $query        = "SELECT count(*) FROM following WHERE follower_id = :id";
    $query_params = array(
        ':id' => intval($_GET['id'])
    );
    
    $result = $db->prepare($query);
    $result->execute($query_params);
    $noOfFollowing = $result->fetchColumn();
}
?>
<html>
<head>
    <title><?php print(isset($usersname) ? $usersname : 'Unknown'); ?> | Breadbin</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/common.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/profile.css" rel="stylesheet" type="text/css">
    <link href="css/settings.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="js/vendor/jquery-1.11.2.min.js"></script>
    <script src="js/vendor/jquery.cookie.js"></script>
    <script src="js/vendor/jquery.color.js"></script>
    <script>
        var uploadingFile = false;
        
        $(document).ready(function(){
            function getUrlParameter(sParam) {
                var sPageURL = window.location.search.substring(1);
                var sURLVariables = sPageURL.split('&');
                
                for (var i = 0; i < sURLVariables.length; i++) {   
                    var sParameterName = sURLVariables[i].split('=');
                    if (sParameterName[0] == sParam) {
                        return sParameterName[1];
                    }
                }
            }        
            
            $(document).on('click','#followBut', function() { 
                var formData = {
                    'url' : getUrlParameter('id')
                };

                $.ajax({
                    type        : 'POST',
                    url         : 'php/follow.php',
                    data        : formData,
                    dataType    : 'json',
                    encode      : true,
                    success:function(data) {
                        if (!data.success) {
                            createError(data.error);
                        }
                    }
                })

                $('.followers').html(parseInt($('.followers').text()) + 1);
                $('#followBut').replaceWith('<button id="unFollowBut" class="buttonstyle">Unfollow</button>');   
            })
            
            $(document).on('click','#unFollowBut', function() {
                var formData = {
                    'url' : getUrlParameter('id')
                };

                $.ajax({
                    type        : 'POST',
                    url         : 'php/unfollow.php',
                    data        : formData,
                    dataType    : 'json',
                    encode      : true
                })

                $('.followers').html(parseInt($('.followers').text()) - 1);
                $('#unFollowBut').replaceWith('<button id="followBut" class="buttonstyle">Follow</button>');
            })
            
            $(document).on('click','.settingsBut', function() {
               $(".settingsBut").fadeOut('normal')
               $("#rightProfile").fadeOut('normal', function(){
                    $("#settingsBox").fadeIn('normal');
                    $(".backBut").fadeIn('normal');
                    $(".leftSettings").animate({ 'marginLeft': '0px' }, 350);
                });
            });
            
            $(".backBut").click(function(){
               $(".backBut").fadeOut('normal');
               $(".leftSettings").animate({ 'marginLeft': '-140px' }, 350);
               $("#settingsBox").fadeOut('normal', function(){
                    $("#rightProfile").fadeIn('normal');
                    $(".settingsBut").fadeIn('normal');
                });
            });
            
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
                    $('.settingsBut').html('Save');
                    $('.settingsBut').addClass('saveBut').removeClass('settingsBut');
                    
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
                $('.saveBut').html('Settings');
                $('.saveBut').addClass('settingsBut').removeClass('saveBut');
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
        });
    </script>
    <script src="js/vendor/progressbar.min.js"></script>
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
                if (!file_exists('img/avatars/' . $_GET['id'] . '/avatar.jpg')) {
                    echo '<div id="userAvatar"></div>';
                } else {
                    echo '<div id="userAvatar" style="background: url(img/avatars/' . $_GET['id'] . '/avatar.jpg) no-repeat;"></div>';
                }


                if ($_GET['id'] == $_SESSION['user']['id']) {
                    echo '<div id="avatarOverlay"><img src="img/Inclined_Pencil_32.png" width="20" height="20"></div>';
                }
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
        </div>
        
        <div id="rightProfile">
           <div id="main">
            <?php
                $query = "SELECT * FROM posts WHERE userid = :id ORDER BY date DESC";
                $query_params = array(
                    ':id' => $userid
                );

                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
                $posts = $stmt->fetchAll();

                foreach ($posts as $row) {
                    if (($row['type'] == 'text') || ($row['type'] == 'imagetext')) {
                        if (preg_match_all('/(?<!\w)@(\w+)/', $row['text'], $matches)) {
                            $users = $matches[1];

                            foreach ($users as $user) {
                                $query = "SELECT id, username FROM users WHERE username = :username";
                                $query_params = array(
                                    ':username' => $user
                                );

                                $stmt = $db->prepare($query);
                                $result = $stmt->execute($query_params);
                                $userFound = $stmt->fetch();

                                if ($userFound) {
                                    $row['text'] = str_replace('@' . $user, '<a href="profile.php?id=' . $userFound['id'] . '">' . $userFound['username'] . '</a>', $row['text']);
                                }

                            }
                        }
                    }

                echo '<ul id="tiles">';

                if ($row['type'] == "image") {
                    list($width, $height) = getimagesize($row['image']);

                    $aspectRatio = $width / $height;
                    $testHeight  = $height / 2;
                    $testWidth   = $width / 2;

                    echo '<li>';
                    echo '<div class="banner">';

                    if ($aspectRatio >= 0) {
                        if ($height >= 0 && $height < 99) {
                            echo '<img class="tiles" src="' . $row['image'] . '" height="100px">';
                        } else if ($height >= 100 && $height < 200) {
                            echo '<img class="tiles" src="' . $row['image'] . '" height="' . $height . '">';
                        } else if ($height >= 200 && $height < 300) {
                            echo '<img class="tiles" src="' . $row['image'] . '" height="' . $height . '">';
                        } else if ($height >= 300 && $height < 350) {
                            echo '<img class="tiles" src="' . $row['image'] . '" height="' . $height . '">';
                        } else if ($height >= 350 && $height < 400) {
                            echo '<img class="tiles" src="' . $row['image'] . '" height="' . $height . '"';
                        } else if ($height >= 400 && $height < 500) {
                            echo '<img class="tiles" src="' . $row['image'] . '" height="' . $height . '">';
                        } else if ($height >= 500 && $height < 600) {
                            echo '<img class="tiles" src="' . $row['image'] . '" height="400px">';
                        } else if ($height >= 600 && $height < 700) {
                            echo '<img class="tiles" src="' . $row['image'] . '" height="400px">';
                        } else if ($height >= 700 && $height < 800) {
                            echo '<img class="tiles" src="' . $row['image'] . '" height="400px">';
                        } else if ($height >= 800 && $height < 1000) {
                            echo '<img class="tiles" src="' . $row['image'] . '" height="' . $testHeight . '">';
                        } else if ($height >= 1000) {
                            echo '<img class="tiles" src="' . $row['image'] . '" height="400px">';
                        } else {
                            echo '<img class="tiles" src="' . $row['image'] . '" height="400px">';
                        }
                    } else if ($aspectRatio == 1) {
                        if ($height >= 0 && $height < 100) {
                            echo '<img class="tiles" src="' . $row['image'] . '" height="100px">';
                        } else if ($height >= 100 && $height < 400) {
                            echo '<img class="tiles" src="' . $row['image'] . '" height="' . $height . '">';
                        } else if ($height >= 400) {
                            echo '<img class="tiles" src="' . $row['image'] . '" height="400px">';
                        }
                    } else {
                        echo '<img class="tiles" src="' . $row['image'] . '" height="220px" width="300px">';
                    }

                    echo '</div>';

                    echo '</li>'; 
            
                } else if ($row['type'] == "text") {
                        echo '<li><div class="box"><p class="textPost">' . $row['text'] . '</p></div></li>';
                } else if ($row['type'] == 'imagetext') {
                    list($width, $height) = getimagesize($row['image']);

                    $aspectRatio = $width / $height;
                    $testHeight  = $height /= 2; 

                    echo '<li>';
                    echo '<div class="banner">';

                    if ($height <= 200) {
                        echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '" width="300px">';
                    } else if ($aspectRatio >= 0) {
                        if ($height >= 0 && $height < 100) {
                            echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '" width="300px">';
                        } else if ($height >= 100 && $height < 200) {
                            echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '" width="300px">';
                        } else if ($height >= 300 && $height < 350) {
                            echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '" width="300px">';
                        } else if ($height >= 350 && $height < 400) {
                            echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '" width="300px">';
                        } else if ($height >= 400 && $height < 500) {
                            echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '" width="300px">';
                        } else if ($height >= 500 && $height < 600) {
                            echo '<img class="blurImage" src="' . $row['image'] . '" height="400px" width="300px">';
                        } else if ($height >= 600 && $height < 1000) {
                            echo '<img class="blurImage" src="' . $row['image'] . '" height="400px" width="300px">';
                        } else if ($height >= 1000) {
                            echo '<img class="blurImage" src="' . $row['image'] . '" height="400px" width="300px">';
                        }
                    } else if ($aspectRatio == 1) {
                        if ($height >= 0 && $height < 100) {
                            echo '<img class="blurImage" src="' . $row['image'] . '" height="100px">';
                        } else if ($height >= 100 && $height < 400) {
                            echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '">';
                        } else if ($height >= 400) {
                            echo '<img class="blurImage" src="' . $row['image'] . '" height="400px" width="300px">';
                        }
                    } else {
                        echo '<img class="blurImage" src="' . $row['image'] . '" width="300px" height="220px">';
                    }



                    echo '<div class="bannerText">';
                        echo $row['text'];
                    echo '</div>';

                    echo '</div>';

                     /*echo '<div class="postTitle">';
                        echo 'Recipie title';
                    echo '</div>';*/

                    echo '<div class="postText">';
                        echo '<img src="../img/text.png" height="30px">';
                    echo '</div>';

                    echo '</li>';
                }
                echo '</ul>';
            }
        ?>
               
               </ul>
            </div>
        </div>
        
        <div id="clearFix"></div>
        
        <div id="rightSettings">
            <div class="leftSettings">
                <ul class="settingsList">
                    <li class="settingsListFirst">
                        Account Details
                    </li>
                <a href="privacySettings.php" class="settingsLinks">
                    <li class="settingsList">
                        Privacy
                    </li>
                </a>
                    <li class="settingsList">
                        Privacy
                    </li>
                    <li class="settingsList">
                        Privacy
                    </li>
                    <li class="settingsList">
                        Privacy
                    </li>
                    <a class="passwordReset">
                    <li class="settingsList">
                        Password reset
                    </li>
                    </a>
                    <li class="settingsListLast">
                        Delete account
                    </li>
                </ul>
            </div>
            
            <div id="settingsBox" style="height:500px;">
                <div class="rightSettings">
                    <div class="accountSettingsField">
                        <div class="settingsHeader">
                            <h3 class="settings">Account Details</h3>
                            <p class="settingsDetail">Update your account details</p>
                        </div>
                        <form action="php/SettingsUpdate.php" method="post" class="accountSettings">
                            <label>First name: </label>
                                <input type="text" name="firstname" class="settings" id="setFirstname" value="<?php echo $firstname;?>">
                                <br>
                                <br>
                            <label>Last name: </label>
                                <input type="text" name="lastname" class="settings" id="setLastname" value="<?php echo $lastname;?>">
                                <br>
                                <br>
                            <label>Email: </label>
                                <input type="text" name="email" class="settings" id="setEmail" value="<?php echo $email; ?>">
                                <br>
                                <br>
                           <label> Colour: </label>
                                <select name="colour" class="settings" id="setColour">
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

                    <div class="passwordSettingsField">
                        <div class="settingsHeader">
                            <h3 class="settings">Reset your password</h3>
                            <p class="settingsDetail"></p>
                        </div>
                        <form action="php/passwordUpdate.php" method="post" class="accountSettings">
                            <label>Current Password: </label>
                                <input type="password" name="currentPassword" class="settings" id="currentPassword">
                                <br>
                                <br>
                            <label>New password: </label>
                                <input type="password" name="newPassword" class="settings" id="newPassword">
                                <br>
                                <br>
                            <label>Verify password: </label>
                                <input type="password" name="newPassword2" class="settings" id="newPassword2">
                                <br>
                                <br>

                                <input type="submit" value="Save" class="saveSettings">
                        </form>
                    </div>
                </div>
            </div>
            
            <div id="profileButtons">
                <?php
                    if (isset($usersname)) {
                        if (($userid != $_SESSION['user']['id'])) {
                ?>
                <div class="bottomRow">
                    <?php
                        $query = "SELECT * FROM following WHERE follower_id = :id AND user_no = :userid";
                        $query_params = array(
                            ':id' => $_SESSION['user']['id'],
                            ':userid' => $_GET['id']
                        );
        
                        $stmt   = $db->prepare($query);
                        $result = $stmt->execute($query_params);
                        $row    = $stmt->fetch();

                        if ($row['user_no'] != intval($_GET['id'])) {
                            echo '<button id="followBut" class="buttonstyle">Follow</button>';
                        } else {
                            echo '<button id="unFollowBut" class="buttonstyle">Unfollow</button>';
                        }
                    ?>
                    <button id="messageBut" class="buttonstyle">Message</button>
                    <button id="reportBut" class="buttonstyle">Report</button>
                </div>
   
                <?php
                    } else {
                ?>
                <div class="bottomRow">
                    <button class="settingsBut buttonstyle">Settings</button>
                    <button class="backBut buttonstyle">Back</button>
                </div>
                
                <?php
                    }
                }
                ?> 
            </div>
            
            <div class="clearFix"></div>
        </div>
            
    <script src="js/formSettings.js"></script>
    <script src="js/vendor/jquery.wookmark.js"></script>
    <script type="text/javascript">
        var colors = [
            "rgb(138, 230, 138)",
            "rgb(102, 153, 255)",
            "rgb(255, 181, 64)",
            "rgb(255, 102, 204)"
        ];

        var boxes = document.querySelectorAll(".box");

        for (i = 0; i < boxes.length; i++) {
          // Pick a random color from the array 'colors'.
          boxes[i].style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
          boxes[i].style.width = '300';
          boxes[i].style.height = '230';
          boxes[i].style.display = 'inline-table';
          boxes[i].style.margin = '0';
          boxes[i].style.textAlign = 'center';
          boxes[i].style.verticalAlign = 'middle';
          boxes[i].style.position = 'relative';
        }

        $(document).ready(new function() {
          // Prepare layout options.
          var options = {
            autoResize: true, // This will auto-update the layout when the browser window is resized.
            container: $('#main'), // Optional, used for some extra CSS styling
            offset: 5, // Optional, the distance between grid items
            itemWidth: 310 // Optional, the width of a grid item
          };

          // Get a reference to your grid items.
          var handler = $('#tiles li');

          // Call the layout function.
          handler.wookmark(options);

          // Capture clicks on grid items.
         
        });
    </script>
    
    <form id="avatarForm" method="POST" enctype="multipart/form-data">
        <div style='height: 0px;width:0px; overflow:hidden;'><input id="upfile" type="file" value="upfile" accept="image/*" onchange="submitAvatar()"/></div>
    </form>
        
    <script src="js/formChangeAvatar.js"></script>
</body>
</html>