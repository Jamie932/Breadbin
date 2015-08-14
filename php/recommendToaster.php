<?php 
    require("php/common.php");

        $query = "SELECT * FROM users WHERE id <> :id AND id NOT IN (SELECT user_no FROM following WHERE follower_id = :id) ORDER BY RAND() LIMIT 3"; 
        $query_params = array(':id' => $_SESSION['user']['id']); 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
        $randUser = $stmt->fetchAll();
        
        $query = "SELECT * FROM user_settings WHERE user_id = :id"; 
        $query_params = array(':id' => $_SESSION['user']['id']); 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
        $row = $stmt->fetch();

        if($row){ 
            if ($row['colour'] == 2) {
                $colour = 'rgba(102, 153, 255, 0.2)';
            } else if ($row['colour'] == 3) {
                $colour = 'rgba(0, 197, 30, 0.2)';
            } else if ($row['colour'] == 4) {
                $colour = 'rgba(236, 88, 88, 0.2)';
            } else if ($row['colour'] == 5) {
                $colour = 'rgba(140, 104, 216, 0.2)';
            } else if ($row['colour'] == 6) {
                $colour = 'rgba(204, 122, 176, 0.2)';
			} else if ($row['colour'] == 7) { 
                $colour = 'rgba(54, 54, 54, 0.2)';
			} else {
                $colour = 'rgba(246, 166, 40, 0.2)';
            }
        }
        
        if ($randUser) {
            echo '<div id="recommendBox" class="sideBox">';
            echo '<div class="boxTitle">Recommended toasters - <a href="discover.php?f=5">See More</a></div>';
            
            foreach ($randUser as $row) {
                $user = $row['id'];
                $usersname = $row['username'];

                echo '<div class="userRecom">';
                    echo '<div class="usericoRecom">';
                
                    if (!file_exists('img/avatars/' . $row['id'] . '/avatar.jpg')) {
                        echo '<img src="img/profile2.png" height="50px" width="50px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    } else { 
                        echo '<img src="img/avatars/' . $row['id'] . '/avatar.jpg" height="50px" width="50px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    }
                        
                    echo '</div>';
                    echo '<div class="usernameRecom"><a href="profile.php?id=' . $user . '">' . $usersname . '</a></div>';
                echo '</div>';
            }
            echo '</div>';
            
        }
?>