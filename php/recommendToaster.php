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
				
				echo '<a class="recomImg" href="profile.php?id=' . $user . '">
					<img src="' . (file_exists('img/avatars/' . $row['id'] . '/avatar.jpg') ? "/img/avatars/" . $row['id'] . "/avatar.jpg" : "/img/profile2.png") . '" class="avatarImg">

					<span>
						<div id="imageHoverLarge">
							<img src="' . (file_exists('img/avatars/' . $row['id'] . '/avatar.jpg') ? "/img/avatars/" . $row['id'] . "/avatar.jpg" : "/img/profile2.png") . '"  width="165px" style="margin-top: -14px;">
						</div>

						<div id="hoverUsername">
							<h7>'.$usersname.'</h7>
						</div>

						<div id="hoverBio">
							'.$bio.
						'</div>
					</span>
				</a>';

				echo '</div>';
            }
            echo '</div>';
            
        }
?>