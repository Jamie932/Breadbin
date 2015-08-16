<?php 
    require("php/common.php");

        $query = "SELECT * FROM users WHERE id <> :id AND id NOT IN (SELECT user_no FROM following WHERE follower_id = :id) ORDER BY RAND() LIMIT 8"; 
        $query_params = array(':id' => $_SESSION['user']['id']); 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
        $randUser = $stmt->fetchAll();
        
        $query = "SELECT * FROM user_settings WHERE user_id = :id"; 
        $query_params = array(':id' => $_SESSION['user']['id']); 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
        $row = $stmt->fetch();
        
        if ($randUser) {
            echo '<div id="recommendBox" class="sideBox">';
            echo '<div class="boxTitle">Recommended toasters - <a href="discover.php?f=5">See More</a></div>';
            
            foreach ($randUser as $row) {
                $user = $row['id'];
                $usersname = $row['username'];
                $bio = $row['bio'];
				
				echo '<div class="usericoRecom">';
 
				if (!file_exists('img/avatars/' . $row['id'] . '/avatar.jpg')) {
					echo '<a class="recomImg" href="profile.php?id=' . $user . '"><img src="img/profile2.png" height="57px" width="57px" style="border: 1px solid rgba(54, 54, 54, 0.25); border-radius: 5%;"><span><div id="imageHoverLarge"><img src="img/profile2.png" width="165px" style="margin-top: -14px;"></div><div id="hoverUsername"><h7>'.$usersname.'</h7></div></span></a>'; 
				} else { 
					echo '<a class="recomImg" href="profile.php?id=' . $user . '"><img src="img/avatars/' . $row['id'] . '/avatar.jpg" height="57px" width="57px" style="border: 1px solid rgba(54, 54, 54, 0.25); border-radius: 5%;"><span><div id="imageHoverLarge"><img src="img/avatars/' . $row['id'] . '/avatar.jpg" width="165px"></div><div id="hoverUsername"><h7>'.$usersname.'</h7></div><div id="hoverBio">'.$usersname.'</div></span></a>';
				}

				echo '</div>';
            }
            echo '</div>';
            
        }
?>