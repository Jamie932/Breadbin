<!DOCTYPE html>
<?php
    require("php/common.php");
    require("php/checkLogin.php");
?>
<html>
<head>
    <title>Discovery | Breadbin</title>
    <link href="css/common.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/discover.css" rel="stylesheet" type="text/css">
    <link href="css/vendor/lazyYT.css" rel="stylesheet" type="text/css">
    <link href="css/vendor/normalize.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="js/vendor/jquery-1.11.2.min.js"></script>
    <script src="js/vendor/jquery.cookie.js"></script>
    <script src="js/vendor/jquery.unveil.js"></script>
    <script src="js/vendor/jquery.wookmark.js"></script>
    <script src="js/vendor/jquery.hoverIntent.js"></script>
    <script src="js/tileFunctions.js"></script>
    <script type="text/javascript" src="js/vendor/lazyYT.js"></script>
    <script>
        $( document ).ready(function() {
			$('.js-lazyYT').lazyYT(); 
		});
        
        $(window).load(function() { 
            $('#mainLoader').hide();
            $("#content").css("opacity", "1");  
            $('#content').css("pointer-events", "auto");
        });
    </script>
</head>
<body>
    <noscript>
      <META HTTP-EQUIV="Refresh" CONTENT="0;URL=error.php">
    </noscript>    
    
    <?php require('php/template/navbar.php'); ?>
      
    <div id="categories" style="background-color:#fff">
        <ul class="cats">

			<li class="cats">
                <a <?php echo empty($_GET) ? 'class="active"' : 'class="catLink"' ?> href="discover.php">All</a>
            </li>
            <li class="cats">
                <a <?php echo $_GET['f'] == 1 ? 'class="active"' : 'class="catLink"' ?> href="discover.php?f=1">Staff Recommendations</a>
            </li>
            <li class="cats">
                <a <?php echo $_GET['f'] == 2 ? 'class="active"' : 'class="catLink"' ?> href="discover.php?f=2">Top Posts</a>
            </li>
            <li class="cats">
                <a <?php echo $_GET['f'] == 3 ? 'class="active"' : 'class="catLink"' ?> href="discover.php?f=3">Just Pictures</a>
            </li>
            <li class="cats">
                <a <?php echo $_GET['f'] == 4 ? 'class="active"' : 'class="catLink"' ?> href="discover.php?f=4">Just Text</a>
            </li>
            <li class="cats">
                <a <?php echo $_GET['f'] == 5 ? 'class="active"' : 'class="catLink"' ?> href="discover.php?f=5">People</a>
            </li>
		</ul>
    </div>
        
    <div id="content">
        <div id="main">
            <?php
            /* userid <> :id AND */ 
			$query = "SELECT * FROM posts WHERE userid != :id AND userid NOT IN (SELECT user_no FROM following WHERE follower_id = :id) ORDER BY RAND()";

			if (!empty($_GET)) { //All
				if ($_GET['f'] == 1) { //Staff Recommended
					$query = "SELECT * FROM posts WHERE userid != :id AND favourite = 1 AND userid NOT IN (SELECT user_no FROM following WHERE follower_id = :id) ORDER BY RAND()";
				} else if ($_GET['f'] == 2) { //Top Posts
					$query = "SELECT posts.*, COUNT(post_toasts.userid) AS toasts, COUNT(post_burns.userid) AS burns, (COUNT(post_toasts.userid) - COUNT(post_burns.userid)) AS total FROM posts LEFT JOIN post_toasts ON post_toasts.postid = posts.id LEFT JOIN post_burns ON post_burns.postid = posts.id WHERE posts.userid != :id GROUP BY posts.id HAVING (total) > 0 ORDER BY total";
                    /*AND posts.userid NOT IN (SELECT user_no FROM following WHERE follower_id = :id)*/
				} else if ($_GET['f'] == 3) { //Just Pictures
					$query = "SELECT * FROM posts WHERE userid != :id AND type = 'image' AND userid NOT IN (SELECT user_no FROM following WHERE follower_id = :id) ORDER BY RAND()";
				} else if ($_GET['f'] == 4) {
					$query = "SELECT * FROM posts WHERE userid != :id AND type = 'text' AND userid NOT IN (SELECT user_no FROM following WHERE follower_id = :id) ORDER BY RAND()";
				} else if ($_GET['f'] == 5) {
					$query = "SELECT * FROM posts WHERE userid = :id ORDER BY RAND()";
				}
			} 

            $query_params = array(':id' => $_SESSION['user']['id']);
            $stmt         = $db->prepare($query);
            $result       = $stmt->execute($query_params);
            $posts        = $stmt->fetchAll();

        if (!$posts) {
            echo '<center>Nothing to discover.</center>';
        } else {
			echo '<ul id="tiles">';

                $postNumber=0;    
            
        	foreach ($posts as $row) {
                $postNumber++;
                
				$query        = "SELECT username FROM users WHERE id = :id"; 
				$query_params = array(':id' => $row['userid']);
				$stmt         = $db->prepare($query);
				$result       = $stmt->execute($query_params);
				$test         = $stmt->fetch();

				if ($row['type'] == "image") {                    
					$withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row['image']);
					$imageLocation = $withoutExt . '-profile.jpg';

					echo '<li class="'.$postNumber.'">';
					echo '<div class="banner">';                
					echo '<a href="showPost.php?id=' . $row['id'] . '"><img class="tiles" src="/' . $imageLocation . '"></a>';
					echo '</div>';

                    echo '<div id="bottomImgTools">';
                        echo '<div class="postUsername">';
                            echo '<div class="imageAvatar" style="display: inline; margin-right: 5px;">';
                                echo '<a href="profile.php?id=' . $row['userid'] . '">'
                                echo file_exists($isRoot . 'img/avatars/' . $row['userid'] . '/avatar.jpg') ? '<img src="/img/avatars/' . $row['userid'] . '/avatar.jpg" height="25px" width="25px" style="border-radius: 5%; border: 1px solid rgba(54, 54, 54, 0.25);">' : '<img src="/img/defaultAvatar.png" height="25px" width="25px" style="border-radius: 5%; border: 1px solid rgba(54, 54, 54, 0.25);">'; 
                            echo '</div>';
                            echo '<div class="profileName" style="display: inline; position: absolute; top: 6px;">';
				                echo '' . $test['username'] .'</a>'; 
					        echo '</div>';
					    echo '</div>';
                        echo '<div class="postLikeToast">';
				            echo '<i class="fa fa-arrow-circle-up"></i>&nbsp;<i class="fa fa-arrow-circle-down"></i>';
					    echo '</div>';
                    echo '</div>';

					echo '</li>'; 

				} else if ($row['type'] == "text") {
					echo '<li class="'.$postNumber.'"><div class="box" style="background:'.$lighterColour.'"><p class="textPost">' . $row['text'] . '</p>';
						echo '<div id="bottomImgTools">';
                        echo '<div class="postUsername">';
                            echo '<div class="imageAvatar" style="display: inline; margin-right: 5px;">';
                                echo '<a href="profile.php?id=' . $row['userid'] . '">'
                                echo file_exists($isRoot . 'img/avatars/' . $row['userid'] . '/avatar.jpg') ? '<img src="/img/avatars/' . $row['userid'] . '/avatar.jpg" height="25px" width="25px" style="border-radius: 5%; border: 1px solid rgba(54, 54, 54, 0.25);">' : '<img src="/img/defaultAvatar.png" height="25px" width="25px" style="border-radius: 5%; border: 1px solid rgba(54, 54, 54, 0.25);">'; 
                            echo '</div>';
                            echo '<div class="profileName" style="display: inline; position: absolute; top: 6px;">';
				                echo '' . $test['username'] .'</a>'; 
					        echo '</div>';
					    echo '</div>';
                        echo '<div class="postLikeToast">';
				            echo '<i class="fa fa-arrow-circle-up"></i>&nbsp;<i class="fa fa-arrow-circle-down"></i>';
					    echo '</div>'; 
                    echo '</div>';
                    echo '</li>';
				} else if ($row['type'] == 'imagetext') {
					$withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row['image']);
					$imageLocation = $withoutExt . '-profile.jpg';

					echo '<li class="'.$postNumber.'">';
					echo '<div class="banner">';                
					echo '<a href="showPost.php?p=' . $row['id'] . '"><img class="blurImage" src="/' . $imageLocation . '"></a>';
					echo '</div>';

					   echo '<div id="bottomImgTools">';
                        echo '<div class="postUsername">';
                            echo '<div class="imageAvatar" style="display: inline; margin-right: 5px;">';
                                echo '<a href="profile.php?id=' . $row['userid'] . '">'
                                echo file_exists($isRoot . 'img/avatars/' . $row['userid'] . '/avatar.jpg') ? '<img src="/img/avatars/' . $row['userid'] . '/avatar.jpg" height="25px" width="25px" style="border-radius: 5%; border: 1px solid rgba(54, 54, 54, 0.25);">' : '<img src="/img/defaultAvatar.png" height="25px" width="25px" style="border-radius: 5%; border: 1px solid rgba(54, 54, 54, 0.25);">'; 
                            echo '</div>';
                            echo '<div class="profileName" style="display: inline; position: absolute; top: 6px;">';
				                echo '' . $test['username'] .'</a>'; 
					        echo '</div>';
					    echo '</div>';
                        echo '<div class="postLikeToast">';
				            echo '<i class="fa fa-arrow-circle-up"></i>&nbsp;<i class="fa fa-arrow-circle-down"></i>';
					    echo '</div>';
                    echo '</div>';

					echo '</li>';
				} else if ($row['type'] == "video") {
                    echo '<li class="'.$postNumber.'">';
                        echo '<div class="banner">';                
                            echo '<div class="js-lazyYT" data-youtube-id="'.$row['text'].'" data-width="300px" data-height="194px"></div>';
                        echo '</div>';
                    echo '</li>'; 
                }
			}
		}
		?>
               
               </ul>
            </div>
        </div>
</body>
</html>