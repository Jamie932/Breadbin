<?php
    require("common.php"); 
	require("vendor/timeago.php");

	$query= "SELECT * FROM posts WHERE id IN (SELECT pid FROM post_toasts WHERE uid = :userId) ORDER BY date DESC"; 
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
            if ($count == 3) {
                
               $query = "SELECT * FROM posts WHERE type = 'image' AND userid NOT IN (SELECT user_no FROM following WHERE follower_id = :id) ORDER BY RAND() LIMIT 3";
                /* AND userid <> :id */
                $query_params = array(':id' => $_SESSION['user']['id']); 
                $stmt = $db->prepare($query); 
                $result = $stmt->execute($query_params); 
                $randUser = $stmt->fetchAll();
                
                echo '<div id="contentPost">';
                echo '<div class="contentPostDisc">';
                    foreach ($randUser as $row) {
                        echo '<div class="discImg">';
                            echo '<img src="' . $row['image'] . '" height="100px" width="100px"></div>';
                        echo '</div>';
                    }
                echo '</div>';
                echo '</div>';
                
                $count = 0;
                
                ?>
                    <script>
                        console.log(<? echo json_encode($randUser); ?>);
                    </script>
                <?php
            
            } else {
                
            $count++;
            
            $query = "SELECT * FROM users WHERE id = :id"; 
            $query_params = array(':id' => $row['userid']); 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 

            $userrow = $stmt->fetch();
            $username = 'Unknown';

            $query = "SELECT * FROM post_burns WHERE p_id = :postId AND u_id= :userId"; 
            $query_params = array(':postId' => $row['id'], ':userId' => $_SESSION['user']['id']); 

            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params); 
            $ifBurnt = $stmt->rowCount();

            $query = "SELECT * FROM post_toasts WHERE pid = :postId AND uid= :userId"; 
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
                if (!file_exists($row['image'])) {
                    $query = "DELETE FROM posts WHERE id = :id"; 
                    $query_params = array(':id' => $row['id']); 

                    $stmt = $db->prepare($query); 
                    $result = $stmt->execute($query_params); 
                    
                    echo '<script>window.location.reload()</script>';
                    
                }
                
                list($width, $height) = getimagesize($row['image']);

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
                echo '<div class="contentPostImage ' . $class . '"><img src="' . $row['image'] . '"><div class="imgtext">' . $row['text'] . '</div></div>';
            } else if ($row['type'] == "image") {
                echo '<div id="contentPost" class="post-' . $row['id'] . '">';
                echo '<div class="contentPostImage ' . $class . '"><img src="' . $row['image'] . '"></div>';
            } else {
                echo '<div id="contentPost" class="post-' . $row['id'] . '">';
                echo '<div class="contentPostText">' . $row['text'] . '</div>';
            }
                echo '<div id="contentInfoText">';
                    echo '<div class="left"><a href="profile.php?id=' . $row['userid'] . '">' . $username . '</a></div>';
                    echo '<div class="right">';

                    if (!empty($_SESSION['user']['rank']) && ($_SESSION['user']['rank'] != "user") && ($row['userid'] != $_SESSION['user']['id'])) {
                        echo '<div class="timeago" style="padding-right: 17px;">' . timeAgoInWords($row['date']) . '</div>';
                        echo '<div class="admin"><i class="fa fa-trash-o"></i><i class="fa fa-heart-o"></i></div>';
                    } else {
                        echo '<div class="timeago">' . timeAgoInWords($row['date']) . '</div>';
                    }
                    echo '</div>';
                echo '</div>';
            echo '</div>';

            if ($_SESSION['user']['id'] == $row['userid']) {
                echo '<div id="contentLike" class="post-' . $row['id'] . '"><p class="delete">Delete</p>';
                echo '<p class="totalToasts">' .$totalToasts. '</p></div>';
            } else {
                echo '<div id="contentLike" class="post-' . $row['id'] . '">';
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
    }
    }
?>