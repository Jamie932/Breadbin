<?php
    require("common.php"); 
	require("timeago.php");
	
	$query = "SELECT * FROM posts ORDER BY date DESC"; 
    $stmt = $db->prepare($query); 
    $result = $stmt->execute(); 
	$posts = $stmt->fetchAll();

    $postIdpls = $row['id'];
	
	foreach ($posts as $row) {
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
            $imgName = ltrim($row['image'], "/.");
            
            if (!file_exists($imgName)) {
                $query = "DELETE FROM posts WHERE id = :id"; 
                $query_params = array(':id' => $row['id']); 

                $stmt = $db->prepare($query); 
                $result = $stmt->execute($query_params); 
            }
            
            list($width, $height) = getimagesize($imgName);
            
            if ($width > 640) {
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
                        $row['text'] = str_replace('@' .$user, '<a href="profile.php?id=' .$userFound['id'] . '">' . $userFound['username'] . '</a>', $row['text']);
                    }
                    
                }
            }
        }
        
        if ($row['type'] == "imagetext") {
            echo '<div id="contentPost" class="post-' . $row['id'] . '">';
            echo '<div class="contentPostImage ' . $class . '"><img src="' . $row['image'] . '"><div class="imgtext">' . $row['text'] . '</div></div>';
                echo '<div id="contentInfoText">';
                    echo '<div class="left"><a href="profile.php?id=' . $row['userid'] . '">' . $username . '</a></div>';
                    echo '<div class="right">' . timeAgoInWords($row['date']) . '</div>';
                echo '</div>';
            echo '</div>';
            
            if ($_SESSION['user']['id'] == $row['userid']) {
                echo '<div id="contentLike" class="post-' . $row['id'] . '"><p class="delete">Delete</p></div><br>';
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
                echo '<p class="totalToasts">' .$totalToasts. '</div><br>'; 
            }             
        } else if ($row['type'] == "image") {
            echo '<div id="contentPost" class="post-' . $row['id'] . '">';
            echo '<div class="contentPostImage ' . $class . '"><img src="' . $row['image'] . '"></div>';
                 echo '<div id="contentInfoText">';
                    echo '<div class="left"><a href="profile.php?id=' . $row['userid'] . '">' . $username . '</a></div>';
                    echo '<div class="right">' . timeAgoInWords($row['date']) . '</div>';
                echo '</div>';
            echo '</div>';
            
            if ($_SESSION['user']['id'] == $row['userid']) {
                echo '<div id="contentLike" class="post-' . $row['id'] . '"><p class="delete">Delete</p></div><br>';
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
                echo '<p class="totalToasts">' .$totalToasts. '</div><br>'; 
            }
            
        } else if ($row['type'] == "text") { 
            echo '<div id="contentPost" class="post-' . $row['id'] . '">';
                echo '<div class="contentPostText">' . $row['text'] . '</div>';
                echo '<div id="contentInfoText">';
                    echo '<div class="left"><a href="profile.php?id=' . $row['userid'] . '">' . $username . '</a></div>';
                    echo '<div class="right">' . timeAgoInWords($row['date']) . '</div>';
                echo '</div>';
            echo '</div>';
            
            if ($_SESSION['user']['id'] == $row['userid']) { 
                echo '<div id="contentLike" class="post-' . $row['id'] . '">
                    <p class="delete">Delete</p>
                    </div><br>';
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
                echo '<p class="totalToasts">' .$totalToasts. '</p></div><br>';  
            }
        }
	}
?>