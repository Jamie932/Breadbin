<?php 
    require("php/common.php");

        $query = "SELECT * FROM users WHERE id <> :id AND id NOT IN (SELECT user_no FROM following WHERE follower_id = :id) ORDER BY RAND() LIMIT 3"; 
        $query_params = array(':id' => $_SESSION['user']['id']); 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
        $randUser = $stmt->fetchAll();

        $query = "SELECT * FROM user_settings WHERE id = :id"; 
        $query_params = array(':id' => $_SESSION['user']['id']); 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
        $borderCul = $stmt->fetchAll();

        if($borderCul){ 
            if ($borderCul['colour'] == 2) {
                $colour = '#6699FF';
            } else if ($borderCul['colour'] == 3) {
                $colour = 'rgba(0, 197, 30, 0.2)';
            } else if ($borderCul['colour'] == 4) {
                $colour = '#EC5858';
            } else if ($borderCul['colour'] == 5) {
                $colour = '#8C68D8';
            } else if ($borderCul['colour'] == 6) {
                $colour = '#CC7AB0';
			} else if ($borderCul['colour'] == 7) { 
                $colour = '#363636';
			} else {
                $colour = '#F6A628';  
            }
        }
        
        if ($randUser) {
            echo '<div id="recommendBox" class="sideBox">';
            echo '<div class="boxTitle">Recommended toasters</div>';
            
            foreach ($randUser as $row) {
                $user = $row['id'];
                $usersname = $row['username'];

                echo '<div class="userRecom">';
                    echo '<div class="usericoRecom">';
                
                    if (!file_exists('img/avatars/' . $row['id'] . '/avatar.jpg')) {
                        echo '<img src="img/profile2.png" height="50px" width="50px" style="border-radius:50%; border: 1px solid ' .$colour. ')">';
                    } else { 
                        echo '<img src="img/avatars/' . $row['id'] . '/avatar.jpg" height="50px" width="50px" style="border-radius:50%; border: 1px solid ' .$colour. ')">';
                    }
                        
                    echo '</div>';
                    echo '<div class="usernameRecom"><a href="profile.php?id=' . $user . '">' . $usersname . '</a></div>';
                echo '</div>';
            }
            echo '</div>';
            
        }
?>