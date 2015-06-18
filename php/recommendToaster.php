<?php 
    require("php/common.php");

        $query = "SELECT * FROM users WHERE id <> :id AND id NOT IN (SELECT user_no FROM following WHERE follower_id = :id) ORDER BY RAND() LIMIT 3"; 
        $query_params = array(':id' => $_SESSION['user']['id']); 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
        $randUser = $stmt->fetchAll();
        
        
        foreach ($randUser as $row) {
            $user = $row['id'];
            $usersname = $row['username'];
        
            echo '<div class="userRecom">';
                echo '<div class="usericoRecom">';
                    echo '<img src="img/cat.jpg" height="50px" width="50px">';
                echo '</div>';
                echo '<div class="usernameRecom"><a href="profile.php?id=' . $user . '">' . $usersname . '</a></div>';
            echo '</div>';
        } 
        
        if (!$row['id']) {
            echo 'silly fuck no more';
        }
?>