<?php
    require("common.php"); 
	require("timeago.php");
	
	$query = "SELECT * FROM posts ORDER BY date DESC"; 
    $stmt = $db->prepare($query); 
    $result = $stmt->execute(); 
	$posts = $stmt->fetchAll();
	
	foreach ($posts as $row) {
		$query = "SELECT * FROM users WHERE id = :id"; 
		$query_params = array(':id' => $row['userid']); 
        
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
        
		$userrow = $stmt->fetch();
		$username = 'Unknown';
        
        $totalToasts = $row['toasts'] - $row['burns'];
				
		if($userrow){ 
			$username = $userrow['username'];
        } else {
            $query = "DELETE FROM posts WHERE userid = :userid"; 
            $query_params = array(':userid' => $row['userid']); 

            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        }
		
        if ($row['type'] == "image") {     
            echo '<div id="contentPost" class="post-' . $row['id'] . '">';
            echo '<div class="contentPostImage"></div>';
                echo '<div class="contentPostInfo">';
                    echo '<div id="contentInfoText">';
                        echo '<div class="left"><a href="profile.php?id=' . $row['userid'] . '">' . $username . '</a></div>';
                        echo '<div class="right">' . timeAgoInWords($row['date']) . '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
            
            if ($_SESSION['user']['id'] == $row['userid']) {
                echo '<div id="contentLike" class="post-' . $row['id'] . '"><p class="delete">Delete</p></div><br>';
            } else {
                echo '<div id="contentLike" class="post-' . $row['id'] . '">
                <p class="toast">Toast</p>
                <p class="burn">Burn</p>
                <p class="report">Report</p>';
                echo '<p>' .$totalToasts. '</div><br>'; 
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
                echo '<div id="contentLike" class="post-' . $row['id'] . '">
                <p class="toast">Toast</p>
                <p class="burn">Burn</p>
                <p class="report">Report</p>';
                echo '<p class="totalToasts">' .$totalToasts. '</p></div><br>';  
            }
        }
	}
?>