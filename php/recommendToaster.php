<?php 
    require("php/common.php");

    $query = "SELECT * FROM users ORDER BY RAND() LIMIT 3"; 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute(); 
        $row = $stmt->fetchAll();

        if($row){ 
            $user = $row['id'];
            $usersname = $row['username'];
        }
        
        foreach ($row) {
            echo '<div class="userRecom">';
                echo '<div class="usericoRecom">';
                    echo '<img src="img/cat.jpg" height="50px" width="50px">';
                echo '</div>';
                echo '<div class="usernameRecom"><a href="profile.php?id=' . $user . '">' . $usersname . '</a></div>';
            echo '</div>';
        }
?>