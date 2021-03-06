<?php
    require("common.php"); 
	require("vendor/timeago.php");

    $postsPerPage = 10;
    $groupNumber = $_POST['groupNumber'] ? $_POST['groupNumber'] : 0;
    $position = $groupNumber * $postsPerPage;

    $query= "SELECT posts.*, COUNT(post_toasts.userid) AS toasts, COUNT(post_burns.userid) AS burns FROM posts LEFT JOIN post_toasts ON post_toasts.postid = posts.id LEFT JOIN post_burns ON post_burns.postid = posts.id WHERE id IN (SELECT postid FROM post_toasts WHERE userid = :userId) GROUP BY posts.id ORDER BY date DESC LIMIT " . $postsPerPage . " OFFSET " . $position; 
    $query_params = array(':userId' => $_SESSION['user']['id']);
    $stmt = $db->prepare($query); 
    $result = $stmt->execute($query_params); 
	$posts = $stmt->fetchAll();
	
    if (!$posts) {
        echo '<div id="contentPost">';
            echo '<div class="contentPostText" style="padding-top: 65px;"><center>You haven\'t toasted anything.</center></div>';
        echo '</div>';
    } else {
        
        $count = 0;
        
        foreach ($posts as $row) {
            if ($count == 7) {
                
               $query = "SELECT * FROM posts WHERE type = 'image' AND userid NOT IN (SELECT user_no FROM following WHERE follower_id = :id) ORDER BY RAND() LIMIT 4";
                /* AND userid <> :id */
                $query_params = array(':id' => $_SESSION['user']['id']); 
                $stmt = $db->prepare($query); 
                $result = $stmt->execute($query_params); 
                $randUser = $stmt->fetchAll();
                
                echo '<div id="contentPost">';
                echo '<div class="contentPostDisc">';
                echo '<h5>Fancy some more</h5>';
                    echo '<ul class="images">';
                        foreach ($randUser as $row) {
                                $query = "SELECT * FROM users WHERE id = :id"; 
                                $query_params = array(':id' => $row['userid']); 
                                $stmt = $db->prepare($query); 
                                $result = $stmt->execute($query_params); 
                                $userrow = $stmt->fetch();
                            
                                echo '<li class="eachImg"><img src="/' . $row['image'] . '" height="130px" width="130px"></li>';
                        }
                    echo '</ul>';
                echo '</div>';
                echo '</div>';
                
                $count = 0;
            
            } else {
                
            $count++;
            
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
				echo '<div id="contentAvatar">';
					echo '<a class="recomImg" href="profile.php?id=' . $row['userid'] . '">
				<img src="' . (file_exists($isRoot . 'img/avatars/' . $row['userid'] . '/avatar.jpg') ? "/img/avatars/" . $row['userid'] . "/avatar.jpg" : "/img/defaultAvatar.png") . '" class="recomAvatarImg">

				<span class="hoverSpan">
						<div id="imageHoverLarge">
						<img src="' . (file_exists($isRoot . 'img/avatars/' . $row['userid'] . '/avatar.jpg') ? "/img/avatars/" . $row['userid'] . "/avatar.jpg" : "/img/defaultAvatar.png") . '"  width="191px" style="margin-top: -14px;">
					   </div>
                    
                        <div id="hoverSettings">
                                <i class="fa fa-user-plus" style="font-size: 2em;"></i>
                        </div>

						<div id="hoverUsername">
							<h7>'.$username.'</h7>
						</div>

						<div id="hoverBio">
							'.$bio.
						'</div>
					</span>
				</a>';
                        echo $row['favourite'] ? '<div id="heart"><i class="fa fa-heart" style="cursor: default;"></i></div>' : '';
				echo '</div>';
                    
			
                echo '<div id="contentPost" class="post-' . $row['id'] . '">';
                   
            if ($row['type'] == "imagetext") {
				echo '<div class="contentPostImage ' . $class . '">';
                echo '<img src="/' . $img . '"><div class="imgtext">' . $row['text'] . '</div></div>';
				
            } else if ($row['type'] == "image") {
				echo '<div class="contentPostImage ' . $class . '">';
                echo '<img src="/' . $img . '"></div>';
				
            } else if ($row['type'] == "text") {
                echo '<div class="contentPostText">';		
                echo '<p style="margin: 0;">' . $row['text'] . '</p></div>';
				
            } else if ($row['type'] == "recipe") {
                $instrucNo = 0;
				echo '<div class="contentPostText">';
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
                echo $row['favourite'] ? '<div class="contentPostImage  imgNoPadding favouriteImg">' : '<div class="contentPostVideo imgNoPadding">';
                echo '<div class="js-lazyYT" data-youtube-id="'.$row['text'].'" data-width="640px" data-height="361px"></div></div>'; 
            }
            
            /*echo '<div class="commentUnderPost">';
                    echo '<div class="upperComment">';
                    echo '<input class="commentBox" placeholder="Write your comment here..." maxlength="100"></input>';
                    echo '</div>';
                echo '</div>';*/
			
			echo '<div id="contentInfoText">';
				echo '<div class="left"><a href="profile.php?id=' . $row['userid'] . '">' . $username . '</a></div>';
				echo '<div class="right">';

				if (($_SESSION['user']['rank'] == "owner" || $_SESSION['user']['rank'] == "admin") && ($row['userid'] != $_SESSION['user']['id'])) {
					echo '<div class="timeago" style="padding-right: 17px;"><a href="showPost.php?p=' . $row['id'] . '" target="_blank">' . timeAgoInWords($row['date']) . '</a></div>';
					echo '<div class="admin post-' . $row['id'] . '"><i class="fa fa-trash-o"></i>';
					echo ($row['favourite'] ? '<i class="fa fa-heart" style="padding-left: 5px;"></i>' : '<i class="fa fa-heart-o" style="padding-left: 5px;"></i>');
					echo '</div>';
				} else {
					echo '<div class="timeago"><a href="showPost.php?p=' . $row['id'] . '" target="_blank">' . timeAgoInWords($row['date']) . '</a></div>';
				}
				echo '</div>';
			echo '</div>';
		echo '</div>';

		if ($_SESSION['user']['id'] == $row['userid']) {
			echo '<div id="contentLike" class="post-' . $row['id'] . '" style="height: 57px;">'; 
				echo '<div class="totalToasts">' . $totalToasts . '</div>';
				echo '<div class="delete">Delete</div>';
			echo '</div>';
			
		} else {
			echo '<div id="contentLike" class="post-' . $row['id'] . '">';
                echo '<div class="totalToasts">' . $totalToasts . '</div>';  
				echo $ifToasted ? '<div class="untoast">Toast</div>' : '<div class="toast">Toast</div>';
				echo $ifBurnt ? '<div class="unburn">Burn</div>' : '<div class="burn">Burn</div>';
                echo '<div class="report">Report</div>';
			echo '</div>';
			
			echo '<div class="clearFix"></div>';
		}             
		echo '</div>';
        }
    }
    }
?>