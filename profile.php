<?php
    require("php/common.php");
    require("php/checkLogin.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php print(isset($usersname) ? $usersname : 'Unknown'); ?> | Breadbin</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/common.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/profile.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="js/vendor/jquery-1.11.2.min.js"></script>
    <script src="js/vendor/jquery.cookie.js"></script>
    <script src="js/vendor/jquery.color.js"></script>
    <script src="js/pages/profile.js"></script>
    <script src="js/tileFunctions.js"></script>
    <script src="js/vendor/jquery.wookmark.js"></script>
    <script src="js/vendor/progressbar.min.js"></script>
</head>
    
<body>
    <noscript>
      <META HTTP-EQUIV="Refresh" CONTENT="0;URL=error.php">
    </noscript>     
    
    <div id="blackOverlay"></div>   
        
    <?php require('php/template/navbar.php'); ?>
    
    <div id="profileContainer">
        <?php require('php/template/profileLeft.php'); ?>
        
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
                    $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row['image']);
                    $imageLocation = $withoutExt . '-profile.jpg';
             
                    echo '<li>';
                    echo '<div class="banner">';                
                    echo '<img class="tiles" src="' . $imageLocation . '"';
                    echo '</div>';
                    echo '</li>'; 
            
                } else if ($row['type'] == "text") {
                        echo '<li><div class="box"><p class="textPost">' . $row['text'] . '</p></div></li>';
                    
                } else if ($row['type'] == 'imagetext') {
                    $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row['image']);
                    $imageLocation = $withoutExt . '-profile.jpg';

                    echo '<li>';
                    echo '<div class="banner">';
                    echo '<img class="tiles" src="' . $imageLocation . '"';
                    echo '</div>';

                     echo '<div class="postTitle">';
                        echo 'pie title';
                    echo '</div>';

                    echo '<div class="postText">';
                        echo '<img src="../img/text.png" height="23px">';
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
                <button class="saveBut buttonstyle" style="display: none;">Save</button>
            </div>

            <?php
                }
            }
            ?> 
        </div>
        <form id="avatarForm" method="POST" enctype="multipart/form-data">
            <div style='height: 0px;width:0px; overflow:hidden;'><input id="upfile" type="file" value="upfile" accept="image/*" onchange="submitAvatar()"/></div>
        </form>
    </div>
</body>
</html>