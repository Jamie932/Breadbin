<?php 
    require("php/common.php");

    $query = "SELECT username FROM users ORDER BY RAND() LIMIT 1"; 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute(); 
        $row = $stmt->fetch();

        if($row){ 
            $userid = $row['id'];
            $usersname = $row['username'];
        }

        echo '<div class="userRecom">';
            echo '<div class="usericoRecom">';
                echo '<img src="img/cat.jpg" height="50px" width="50px">';
            echo '</div>';
            echo '<div class="usernameRecom"><a href="profile.php?id=' . $userid . '">' . $username . '</a></div>';
        echo '</div>';
?>