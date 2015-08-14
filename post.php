<?php 
    require("php/common.php");
    require("php/checkLogin.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Breadbin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="css/common.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href="css/vendor/lazyYT.css" rel="stylesheet" type="text/css">
    <link href="css/vendor/normalize.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="js/vendor/jquery-1.11.2.min.js"></script>
    <script src="js/vendor/jquery.cookie.js"></script>
    <script src="js/pages/main.js"></script>
    <script src="js/postFunctions.js"></script>
    <script src="js/errorHandler.js"></script>
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
    
    <?php require('php/template/navbar.php');?>
    <?php require('php/template/popup.php');?>
        
    <div id="break"></div>
        
    
    <div id="center">
<?php
    $query        = "SELECT * FROM posts WHERE id = :id";
    $query_params = array(':id' => intval($_GET['id']));
    $stmt   = $db->prepare($query);
    $result = $stmt->execute($query_params);
    $posts    = $stmt->fetch();

    $query= "SELECT * FROM following WHERE follower_id = :userId"; 
    $query_params = array(':userId' => $_SESSION['user']['id']);
    $stmt = $db->prepare($query); 
    $result = $stmt->execute($query_params); 
	$following = $stmt->rowCount();

    $currentID = $_SESSION['user']['id'];

    if ($following == 0 && !$posts) {
        echo '<div id="contentPost">';
            echo '<div class="contentPostText" style="padding-top: 65px;"><center>You don\'t follow any toasters.</center></div>';
        echo '</div>';
    } else if (!$posts) {
        echo '<div id="contentPost">';
            echo '<div class="contentPostText" style="padding-top: 65px;"><center>Your boring toasters haven\'t posted anything.</center></div>';
        echo '</div>';
    } else {
        if ($following == 0) {
            echo '<div id="contentPostFollow">';
                echo '<div class="contentPostText" style="padding-top: 65px;"><center>You don\'t follow any toasters.</center></div>';
            echo '</div>';
            
            echo '<div id="contentLikeFollow">';
                echo '<p class="hide">Hide</p>';
            echo '</div>';  
        }
        
        for ($posts as $row) {
            
            
            $query = "SELECT * FROM users WHERE id = :id"; 
            $query_params = array(':id' => $row['userid']); 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 

            $userrow = $stmt->fetch();
            $username = 'Unknown';

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

            $totalToasts = $row['toasts'] - $row['burns'];

            if($userrow){ 
                $username = $userrow['username'];
            } else {
                $query = "DELETE FROM posts WHERE userid = :userid"; 
                $query_params = array(':userid' => $row['userid']); 

                $stmt = $db->prepare($query); 
                $result = $stmt->execute($query_params); 
            }

            if (($row['type'] == 'image') || ($row['type'] == 'imagetext')) {
                $img = (basename(getcwd()) == "php") ? '../' . $row['image'] : $row['image'];
                
                /*if (!file_exists($img)) {
                    $query = "DELETE FROM posts WHERE id = :id"; 
                    $query_params = array(':id' => $row['id']); 

                    $stmt = $db->prepare($query); 
                    $result = $stmt->execute($query_params); 
                    
                    echo '<script>window.location.reload()</script>';
                    
                }*/
                
                list($width, $height) = getimagesize($img);

                if ($width > 600) {
                    $class = 'imgNoPadding';
                } else {
                    $class = 'imgPadding';
                }
            }

            if (($row['type'] == 'text') || ($row['type'] == 'imagetext')) {
                if (preg_match_all('/(?<!\w)@(\w+)/', $row['text'], $matches)) {
                    $users = $matches[1];

                    foreach ($users as $user) {
                        $query = "SELECT id, username FROM users WHERE username = :username"; 
                        $query_params = array(':username' => $user); 

                        $stmt = $db->prepare($query); 
                        $result = $stmt->execute($query_params);
                        $userFound = $stmt->fetch(); 

                        if ($userFound) {
                            $row['text'] = str_replace('@' .$user, '<a href="profile.php?id=' .$userFound['id'] . '">' . $user . '</a>', $row['text']);
                        }

                    }
                }
            }

            echo '<div id="post">';

            if ($row['type'] == "imagetext") {
                echo '<div id="contentPost" class="post-' . $row['id'] . '">';
                echo '<div id="leftUserImg">';
                    echo '<a href="profile.php?id=' . $row['userid'] . '">';
                    if (!file_exists('img/avatars/' . $row['userid'] . '/avatar.jpg')) {
                        echo '<img src="img/profile2.png" height="50px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    } else { 
                        echo '<img src="img/avatars/' . $row['userid'] . '/avatar.jpg" height="50px" width="50px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    }
                    echo '</a>';
                echo '</div>';
                echo $row['favourite'] ? '<div id="heart"><i class="fa fa-heart" style="cursor: default;"></i></div><div class="contentPostImage ' . $class . ' favouriteImg">' : '<div class="contentPostImage ' . $class . '">';
                echo '<img src="' . $img . '"><div class="imgtext">' . $row['text'] . '</div></div>';
            } else if ($row['type'] == "image") {
                echo '<div id="contentPost" class="post-' . $row['id'] . '">';
                echo '<div id="leftUserImg">';
                    echo '<a href="profile.php?id=' . $row['userid'] . '">';
                    if (!file_exists('img/avatars/' . $row['userid'] . '/avatar.jpg')) {
                        echo '<img src="img/profile2.png" height="50px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    } else { 
                        echo '<img src="img/avatars/' . $row['userid'] . '/avatar.jpg" height="50px" width="50px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    }
                    echo '</a>';
                echo '</div>';
                echo $row['favourite'] ? '<div id="heart"><i class="fa fa-heart" style="cursor: default;"></i></div><div class="contentPostImage ' . $class . ' favouriteImg">' : '<div class="contentPostImage ' . $class . '">';
                echo '<img src="' . $img . '"></div>';
            } else if ($row['type'] == "text") {
                echo '<div id="contentPost" class="post-' . $row['id'] . '">';
                echo '<div id="leftUserImg">';
                    echo '<a href="profile.php?id=' . $row['userid'] . '">';
                    if (!file_exists('img/avatars/' . $row['userid'] . '/avatar.jpg')) {
                        echo '<img src="img/profile2.png" height="50px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    } else { 
                        echo '<img src="img/avatars/' . $row['userid'] . '/avatar.jpg" height="50px" width="50px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    }
                    echo '</a>';
                echo '</div>';
                echo $row['favourite'] ? '<div id="heart"><i class="fa fa-heart" style="cursor: default;"></i></div><div class="contentPostText favouriteText">' : '<div class="contentPostText">';
                echo '<p style="margin: 0;">' . $row['text'] . '</p></div>';
            } else if ($row['type'] == "recipe") {
                $instrucNo = 0;
                echo '<div id="contentPost" class="post-' . $row['id'] . '">';
                echo '<div id="leftUserImg">';
                    echo '<a href="profile.php?id=' . $row['userid'] . '">';
                    if (!file_exists('img/avatars/' . $row['userid'] . '/avatar.jpg')) {
                        echo '<img src="img/profile2.png" height="50px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    } else { 
                        echo '<img src="img/avatars/' . $row['userid'] . '/avatar.jpg" height="50px" width="50px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    }
                    echo '</a>';
                echo '</div>';
                echo $row['favourite'] ? '<div id="heart"><i class="fa fa-heart" style="cursor: default;"></i></div><div class="contentPostText favouriteText">' : '<div class="contentPostText">';
                echo '<div class="recTitle">';
                echo '<h3 class="recTit">' .$row['title']. '</h3>';
                echo '</div>';
                echo '<div class="timeServe">';
                
                $prepArray = json_decode($row['prepTime']);
                
                $prepTimeNo = 0;
                $prepTot = count($prepArray);
                
                echo '<p class="times" style="margin-right: 50px;"><b>Prep time:</b>';
                foreach ($prepArray as $value) {
                    $prepTimeNo++;
                    if ($prepTimeNo == 1 && $value >= 1) {
                        if ($value == 1) {
                            echo ' '. $value .'hr';
                        } else {
                            echo ' '. $value .'hrs';
                        }
                    } else if ($prepTimeNo == 1 && $value == 0) {
                    }
                    
                    if ($prepTimeNo > 1 && $value >= 1) {
                        if ($value == 1) {
                            echo ' '. $value .'min';
                        } else {
                            echo ' '. $value .'mins';
                        }
                    } else if ($prepTimeNo > 1 && $value == 0) {
                    }
                }
                echo '</p>';
                
                $cookArray = json_decode($row['cookTime']);
                
                $cookTimeNo = 0;
                
                echo '<p class="times" style="margin-right: 50px;"><b>Cooking time:</b>'; 
                foreach ($cookArray as $value) { 
                    $cookTimeNo++;
                    if ($cookTimeNo == 1 && $value >= 1) {
                        if ($value == 1) {
                            echo ' '. $value .'hr';
                        } else {
                            echo ' '. $value .'hrs';
                        }
                    }
                    
                    if ($cookTimeNo > 1 && $value >= 1) {
                        if ($value == 1) {
                            echo ' '. $value .'min';
                        } else {
                            echo ' '. $value .'mins';
                        }
                    }
                }
                echo '</p>';
                
                echo '<p class="times"><b>Serves:</b> '. $row['serves'] . '</p>';
                
                echo '</div>';
                echo '<div class="ingredientDis">';
                echo '<h6>Ingredients</h6>';
                
                $ingredArray = json_decode($row['ingred']);
                
                foreach ($ingredArray as $value) { 
                    echo '<p class="ingredList">' .$value. '</p>';
                }
                
                echo '</div>';
                echo '<br>';
                
                echo '<div class="instructionList">';
                echo '<h6>Instructions</h6>';
                
                $instrucArray = json_decode($row['text']);
                
                echo '';
                
                foreach ($instrucArray as $value) { 
                    $instrucNo++;
                    echo '<p class="instructionList"><b class="instructionNo">' .$instrucNo. '. </b>' . $value . '<br></p>';
                }
                echo '';
                
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div id="contentPost" class="post-' . $row['id'] . '">';
                echo '<div id="leftUserImg">';
                    echo '<a href="profile.php?id=' . $row['userid'] . '">';
                    if (!file_exists('img/avatars/' . $row['userid'] . '/avatar.jpg')) {
                        echo '<img src="img/profile2.png" height="50px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    } else { 
                        echo '<img src="img/avatars/' . $row['userid'] . '/avatar.jpg" height="50px" width="50px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    }
                    echo '</a>';
                echo '</div>';
                echo $row['favourite'] ? '<div id="heart"><i class="fa fa-heart" style="cursor: default;"></i></div><div class="contentPostImage  imgNoPadding favouriteImg">' : '<div class="contentPostVideo imgNoPadding">';
                echo '<div class="js-lazyYT" data-youtube-id="'.$row['text'].'" data-width="640px" data-height="361px"></div></div>'; 
                
            }
            
            echo '</div>';
        }
    }
    ?>
        
        <div id="content">
            <ul id="images">
            </ul>
        </div>
        
        <div id="sidebar">
            <div id="uploadBox" class="sideBox">
                quackquackquackquackquackquack
     		</div> 
			
			<?php require('php/recommendToaster.php');  ?>
            
            <div id="supportBox" class="sideBox">
				About Support etc etc
			</div>
            
        </div>        
    </div>
</body>
</html>