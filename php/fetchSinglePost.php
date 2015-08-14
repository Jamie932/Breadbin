<?php
    require("php/common.php");

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
            
            
            $query = "SELECT * FROM users WHERE id = :id"; 
            $query_params = array(':id' => $posts['userid']); 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 

            $userrow = $stmt->fetch();
            $username = 'Unknown';

            $query = "SELECT * FROM post_burns WHERE postid = :postId AND userid= :userId"; 
            $query_params = array(':postId' => $posts['id'], ':userId' => $_SESSION['user']['id']); 

            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params); 
            $ifBurnt = $stmt->rowCount();

            $query = "SELECT * FROM post_toasts WHERE postid = :postId AND userid = :userId"; 
            $query_params = array(':postId' => $posts['id'], ':userId' => $_SESSION['user']['id']);
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params); 
            $ifToasted = $stmt->rowCount();

            $totalToasts = $posts['toasts'] - $posts['burns'];

            if($userrow){ 
                $username = $userrow['username'];
            } else {
                $query = "DELETE FROM posts WHERE userid = :userid"; 
                $query_params = array(':userid' => $posts['userid']); 

                $stmt = $db->prepare($query); 
                $result = $stmt->execute($query_params); 
            }

            if (($posts['type'] == 'image') || ($posts['type'] == 'imagetext')) {
                $img = (basename(getcwd()) == "php") ? '../' . $posts['image'] : $posts['image'];
                
                /*if (!file_exists($img)) {
                    $query = "DELETE FROM posts WHERE id = :id"; 
                    $query_params = array(':id' => $posts['id']); 

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

            if (($posts['type'] == 'text') || ($posts['type'] == 'imagetext')) {
                if (preg_match_all('/(?<!\w)@(\w+)/', $posts['text'], $matches)) {
                    $users = $matches[1];

                    foreach ($users as $user) {
                        $query = "SELECT id, username FROM users WHERE username = :username"; 
                        $query_params = array(':username' => $user); 

                        $stmt = $db->prepare($query); 
                        $result = $stmt->execute($query_params);
                        $userFound = $stmt->fetch(); 

                        if ($userFound) {
                            $posts['text'] = str_replace('@' .$user, '<a href="profile.php?id=' .$userFound['id'] . '">' . $user . '</a>', $posts['text']);
                        }

                    }
                }
            }

            echo '<div id="post">';

            if ($posts['type'] == "imagetext") {
                echo '<div id="contentPost" class="post-' . $posts['id'] . '">';
                echo '<div id="leftUserImg">';
                    echo '<a href="profile.php?id=' . $posts['userid'] . '">';
                    if (!file_exists('img/avatars/' . $posts['userid'] . '/avatar.jpg')) {
                        echo '<img src="img/profile2.png" height="50px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    } else { 
                        echo '<img src="img/avatars/' . $posts['userid'] . '/avatar.jpg" height="50px" width="50px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    }
                    echo '</a>';
                echo '</div>';
                echo $posts['favourite'] ? '<div id="heart"><i class="fa fa-heart" style="cursor: default;"></i></div><div class="contentPostImage ' . $class . ' favouriteImg">' : '<div class="contentPostImage ' . $class . '">';
                echo '<img src="' . $img . '"><div class="imgtext">' . $posts['text'] . '</div></div>';
            } else if ($posts['type'] == "image") {
                echo '<div id="contentPost" class="post-' . $posts['id'] . '">';
                echo '<div id="leftUserImg">';
                    echo '<a href="profile.php?id=' . $posts['userid'] . '">';
                    if (!file_exists('img/avatars/' . $posts['userid'] . '/avatar.jpg')) {
                        echo '<img src="img/profile2.png" height="50px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    } else { 
                        echo '<img src="img/avatars/' . $posts['userid'] . '/avatar.jpg" height="50px" width="50px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    }
                    echo '</a>';
                echo '</div>';
                echo $posts['favourite'] ? '<div id="heart"><i class="fa fa-heart" style="cursor: default;"></i></div><div class="contentPostImage ' . $class . ' favouriteImg">' : '<div class="contentPostImage ' . $class . '">';
                echo '<img src="' . $img . '"></div>';
            } else if ($posts['type'] == "text") {
                echo '<div id="contentPost" class="post-' . $posts['id'] . '">';
                echo '<div id="leftUserImg">';
                    echo '<a href="profile.php?id=' . $posts['userid'] . '">';
                    if (!file_exists('img/avatars/' . $posts['userid'] . '/avatar.jpg')) {
                        echo '<img src="img/profile2.png" height="50px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    } else { 
                        echo '<img src="img/avatars/' . $posts['userid'] . '/avatar.jpg" height="50px" width="50px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    }
                    echo '</a>';
                echo '</div>';
                echo $posts['favourite'] ? '<div id="heart"><i class="fa fa-heart" style="cursor: default;"></i></div><div class="contentPostText favouriteText">' : '<div class="contentPostText">';
                echo '<p style="margin: 0;">' . $posts['text'] . '</p></div>';
            } else if ($posts['type'] == "recipe") {
                $instrucNo = 0;
                echo '<div id="contentPost" class="post-' . $posts['id'] . '">';
                echo '<div id="leftUserImg">';
                    echo '<a href="profile.php?id=' . $posts['userid'] . '">';
                    if (!file_exists('img/avatars/' . $posts['userid'] . '/avatar.jpg')) {
                        echo '<img src="img/profile2.png" height="50px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    } else { 
                        echo '<img src="img/avatars/' . $posts['userid'] . '/avatar.jpg" height="50px" width="50px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    }
                    echo '</a>';
                echo '</div>';
                echo $posts['favourite'] ? '<div id="heart"><i class="fa fa-heart" style="cursor: default;"></i></div><div class="contentPostText favouriteText">' : '<div class="contentPostText">';
                echo '<div class="recTitle">';
                echo '<h3 class="recTit">' .$posts['title']. '</h3>';
                echo '</div>';
                echo '<div class="timeServe">';
                
                $prepArray = json_decode($posts['prepTime']);
                
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
                
                $cookArray = json_decode($posts['cookTime']);
                
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
                
                echo '<p class="times"><b>Serves:</b> '. $posts['serves'] . '</p>';
                
                echo '</div>';
                echo '<div class="ingredientDis">';
                echo '<h6>Ingredients</h6>';
                
                $ingredArray = json_decode($posts['ingred']);
                
                foreach ($ingredArray as $value) { 
                    echo '<p class="ingredList">' .$value. '</p>';
                }
                
                echo '</div>';
                echo '<br>';
                
                echo '<div class="instructionList">';
                echo '<h6>Instructions</h6>';
                
                $instrucArray = json_decode($posts['text']);
                
                echo '';
                
                foreach ($instrucArray as $value) { 
                    $instrucNo++;
                    echo '<p class="instructionList"><b class="instructionNo">' .$instrucNo. '. </b>' . $value . '<br></p>';
                }
                echo '';
                
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div id="contentPost" class="post-' . $posts['id'] . '">';
                echo '<div id="leftUserImg">';
                    echo '<a href="profile.php?id=' . $posts['userid'] . '">';
                    if (!file_exists('img/avatars/' . $posts['userid'] . '/avatar.jpg')) {
                        echo '<img src="img/profile2.png" height="50px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    } else { 
                        echo '<img src="img/avatars/' . $posts['userid'] . '/avatar.jpg" height="50px" width="50px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    }
                    echo '</a>';
                echo '</div>';
                echo $posts['favourite'] ? '<div id="heart"><i class="fa fa-heart" style="cursor: default;"></i></div><div class="contentPostImage  imgNoPadding favouriteImg">' : '<div class="contentPostVideo imgNoPadding">';
                echo '<div class="js-lazyYT" data-youtube-id="'.$posts['text'].'" data-width="640px" data-height="361px"></div></div>'; 
                
            }
                echo '<div id="contentInfoText">';
                    echo '<div class="left"><a href="profile.php?id=' . $posts['userid'] . '">' . $username . '</a></div>';
                    echo '<div class="right">';

                    if (($_SESSION['user']['rank'] != "user") && ($posts['userid'] != $_SESSION['user']['id'])) {
                        echo '<div class="timeago" style="padding-right: 17px;"><a href="post.php?id=' . $posts['id'] . '">' . timeAgoInWords($posts['date']) . '</a></div>';
                        echo '<div class="admin post-' . $posts['id'] . '"><i class="fa fa-trash-o"></i>';
						echo ($posts['favourite'] ? '<i class="fa fa-heart"></i>' : '<i class="fa fa-heart-o"></i>');
						echo '</div>';
                    } else {
                        echo '<div class="timeago"><a href="post.php?id=' . $posts['id'] . '">' . timeAgoInWords($posts['date']) . '</a></div>';
                    }
                    echo '</div>';
                echo '</div>';
            echo '</div>';

            if ($_SESSION['user']['id'] == $posts['userid']) {
                echo '<div id="contentLike" class="post-' . $posts['id'] . '"><p class="delete">Delete</p>';
                echo '<p class="totalToasts">' .$totalToasts. '</p></div>';
            } else {
                echo '<div id="contentLike" class="post-' . $posts['id'] . '">';
                if ($ifToasted == 0) {
                    echo '<p class="toast">Toast</p>';
                } else {
                    echo '<p class="untoast">Toast</p>';
                } 
                if ($ifBurnt == 0) {
                    echo '<p class="burn">Burn</p>';
                } else {
                    echo '<p class="unburn">Burn</p>';
                }
                echo '<p class="report">Report</p>';
                echo '<p class="totalToasts">' .$totalToasts. '</div>'; 
            }             
            echo '</div>';
    }
?>