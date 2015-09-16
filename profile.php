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
        $rank = $row['rank'];
        
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
<!DOCTYPE html>
<html>
<head>
    <title><?php print(isset($usersname) ? $usersname : 'Unknown'); ?> | Breadbin</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/common.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/profile.css" rel="stylesheet" type="text/css">
    <link href="css/vendor/lazyYT.css" rel="stylesheet" type="text/css">
    <link href="css/vendor/normalize.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="js/vendor/jquery-1.11.2.min.js"></script>
    <script src="js/vendor/jquery.cookie.js"></script>
    <script src="js/vendor/jquery.color.js"></script> 
    <script src="js/vendor/jquery.hoverIntent.js"></script>
    <script src="js/pages/profile.js"></script>
    <script src="js/tileFunctions.js"></script>
    <script src="js/vendor/jquery.wookmark.js"></script>
    <script src="js/vendor/progressbar.min.js"></script>
    
    <script type="text/javascript" src="js/vendor/lazyYT.js"></script>
    <script>
        $( document ).ready(function() {
            $('.js-lazyYT').lazyYT(); 
        });
    </script>
</head>
    
<body>
    <noscript>
      <META HTTP-EQUIV="Refresh" CONTENT="0;URL=error.php">
    </noscript>     
    
    <div id="blackOverlay"></div>   
        
    <?php require('php/template/navbar.php'); ?>
    
    <div id="profileContainer">
        <div id="leftProfile">
            <?php
                if (!file_exists('img/avatars/' . $_GET['id'] . '/avatar.jpg')) {
                    echo '<div id="userAvatar"></div>';
                } else {
                    echo '<div id="userAvatar" style="background: url(img/avatars/' . $_GET['id'] . '/avatar.jpg) no-repeat;"></div>';
                }
                
                if (isset($rank) && !empty($rank) && $rank != "user") { //Add a star
                    echo '<div id="starOverlay"><i class="fa fa-star"></i></div>';
                }
            ?>
            
            <div class="userInfo">            
                <?php
                if (isset($usersname)) {
                    if ($_GET['id'] == $_SESSION['user']['id']) { 
                        echo '<div class="nameRow" style="padding-left:30px">' . $usersname;
                        echo '<div id="avatarOverlay"><i class="fa fa-pencil"></i></div>'; 
                    } else {
                        echo '<div class="nameRow">' . $usersname;
                    }
                    echo '</div>';
                    
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
                }

                echo '<ul id="tiles">';

                foreach ($posts as $row) {
                
				$query        = "SELECT username FROM users WHERE id = :id"; 
				$query_params = array(':id' => $row['userid']);
				$stmt         = $db->prepare($query);
				$result       = $stmt->execute($query_params);
				$test         = $stmt->fetch();
                
                $query = "SELECT * FROM post_burns WHERE postid = :postId AND userid= :userId"; 
                $query_params = array(':postId' => $row['id'], ':userId' => $_SESSION['user']['id']);
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params); 
                $ifBurnt = $stmt->rowCount();

                $query = "SELECT * FROM post_toasts WHERE postid = :postId AND userid = :userId"; 
                $query_params = array(':postId' => $row['id'], ':userId' => $_SESSION['user']['id']);
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params); 
                $ifToasted = $stmt->rowCount();

				if ($row['type'] == "image") {                    
					$withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row['image']);
					$imageLocation = $withoutExt . '-profile.jpg';

					echo '<li>';
					echo '<div class="banner">';                
					echo '<a href="showPost.php?id=' . $row['id'] . '"><img class="tiles" src="/' . $imageLocation . '"></a>';
					echo '</div>';
                    
                    echo '<div id="bottomImgTools">';
                        echo '<div class="postUsername">';
                            echo '<div class="imageAvatar" style="display: inline; margin-right: 5px;">';
                                echo '<a href="profile.php?id=' . $row['userid'] . '">';
                                echo file_exists($isRoot . 'img/avatars/' . $row['userid'] . '/avatar.jpg') ? '<img src="/img/avatars/' . $row['userid'] . '/avatar.jpg" height="25px" width="25px" style="border-radius: 5%; border: 1px solid rgba(54, 54, 54, 0.25);">' : '<img src="/img/defaultAvatar.png" height="25px" width="25px" style="border-radius: 5%; border: 1px solid rgba(54, 54, 54, 0.25);">'; 
                            echo '</div>';
                            echo '<div class="profileName" style="display: inline; position: absolute; top: 6px;">';
				                echo '' . $test['username'] .'</a>'; 
					        echo '</div>';
					    echo '</div>';
                        echo '<div class="postLikeToast" id="post-' . $row['id'] . '">';
                    if ($_SESSION['user']['id'] != $row['userid']) {
                            echo $ifToasted ? '<div class="unToastDisc" style="display: inline;"><i class="fa fa-arrow-circle-up"></i></div>&nbsp;' : '<div class="toastDisc" style="display: inline;"><i class="fa fa-arrow-circle-up"></i></div>&nbsp;';
				            echo $ifBurnt ? '<div class="unBurnDisc" style="display: inline;"><i class="fa fa-arrow-circle-down"></i></div>' : '<div class="burnDisc" style="display: inline;"><i class="fa fa-arrow-circle-down"></i></div>';
					    echo '</div>';
                    }
                    echo '</div>';
                    
					echo '</li>'; 

				} else if ($row['type'] == "text") {
					echo '<li><div class="box" style="background:'.$lighterColour.'"><p class="textPost">' . $row['text'] . '</p>';
                    echo '<div id="bottomImgTools">';
                        echo '<div class="postUsername">';
                            echo '<div class="imageAvatar" style="display: inline; margin-right: 5px;">';
                                echo '<a href="profile.php?id=' . $row['userid'] . '">';
                                echo file_exists($isRoot . 'img/avatars/' . $row['userid'] . '/avatar.jpg') ? '<img src="/img/avatars/' . $row['userid'] . '/avatar.jpg" height="25px" width="25px" style="border-radius: 5%; border: 1px solid rgba(54, 54, 54, 0.25);">' : '<img src="/img/defaultAvatar.png" height="25px" width="25px" style="border-radius: 5%; border: 1px solid rgba(54, 54, 54, 0.25);">'; 
                            echo '</div>';
                            echo '<div class="profileName" style="display: inline; position: absolute; top: 6px;">';
				                echo '' . $test['username'] .'</a>'; 
					        echo '</div>';
					    echo '</div>';
                        echo '<div class="postLikeToast" id="post-' . $row['id'] . '">';
                            if ($_SESSION['user']['id'] != $row['userid']) {
                            echo $ifToasted ? '<div class="unToastDisc" style="display: inline;"><i class="fa fa-arrow-circle-up"></i></div>&nbsp;' : '<div class="toastDisc" style="display: inline;"><i class="fa fa-arrow-circle-up"></i></div>&nbsp;';
				            echo $ifBurnt ? '<div class="unBurnDisc" style="display: inline;"><i class="fa fa-arrow-circle-down"></i></div>' : '<div class="burnDisc" style="display: inline;"><i class="fa fa-arrow-circle-down"></i></div>';
					    echo '</div>';
                    }
					    echo '</div>';
                    echo '</div>';
                    echo '</li>';
				} else if ($row['type'] == 'imagetext') {
					$withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row['image']);
					$imageLocation = $withoutExt . '-profile.jpg';

					echo '<li>';
					echo '<div class="banner">';                
					echo '<a href="showPost.php?p=' . $row['id'] . '"><img class="blurImage" src="/' . $imageLocation . '"></a>';
					echo '</div>';
                        
                    echo '<div id="bottomImgTools">';
                        echo '<div class="postUsername">';
                            echo '<div class="imageAvatar" style="display: inline; margin-right: 5px;">';
                                echo '<a href="profile.php?id=' . $row['userid'] . '">';
                                echo file_exists($isRoot . 'img/avatars/' . $row['userid'] . '/avatar.jpg') ? '<img src="/img/avatars/' . $row['userid'] . '/avatar.jpg" height="25px" width="25px" style="border-radius: 5%; border: 1px solid rgba(54, 54, 54, 0.25);">' : '<img src="/img/defaultAvatar.png" height="25px" width="25px" style="border-radius: 5%; border: 1px solid rgba(54, 54, 54, 0.25);">'; 
                            echo '</div>';
                            echo '<div class="profileName" style="display: inline; position: absolute; top: 6px;">';
				                echo '' . $test['username'] .'</a>'; 
					        echo '</div>';
					    echo '</div>';
                        echo '<div class="postLikeToast" id="post-' . $row['id'] . '">';
                            if ($_SESSION['user']['id'] != $row['userid']) {
                            echo $ifToasted ? '<div class="unToastDisc" style="display: inline;"><i class="fa fa-arrow-circle-up"></i></div>&nbsp;' : '<div class="toastDisc" style="display: inline;"><i class="fa fa-arrow-circle-up"></i></div>&nbsp;';
				            echo $ifBurnt ? '<div class="unBurnDisc" style="display: inline;"><i class="fa fa-arrow-circle-down"></i></div>' : '<div class="burnDisc" style="display: inline;"><i class="fa fa-arrow-circle-down"></i></div>';
					    echo '</div>';
                    }
					    echo '</div>';
                    echo '</div>'; 
                    
					echo '</li>';
				} else if ($row['type'] == "video") {
                    echo '<li class="'.$postNumber.'">';
                        echo '<div class="banner">';                
                            echo '<div class="js-lazyYT" data-youtube-id="'.$row['text'].'" data-width="640px" data-height="378px"></div>';
                        echo '</div>';
                    echo '</li>'; 
                } 
            }
        ?>
               
               </ul>
            </div>
        </div>
        
        <div id="clearFix"></div>
        
        <form id="avatarForm" method="POST" enctype="multipart/form-data">
            <div style='height: 0px;width:0px; overflow:hidden;'><input id="upfile" type="file" value="upfile" accept="image/*" onchange="submitAvatar()"/></div>
        </form>
    </div>
</body>
</html>