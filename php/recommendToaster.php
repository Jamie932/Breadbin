<?php 
    require("php/common.php");

    $query = "SELECT count(*) FROM users ORDER BY RAND() LIMIT 1"; 
        $result = $db->prepare($query); 
        $result->execute();
        $usersCount = $result->fetchColumn(); 

        if($usersCount){ 
            $username = $row['username'];
        }

        echo '<div class="userRecom">';
            echo '<div class="usericoRecom">';
                echo '<img src="img/cat.jpg" height="50px" width="50px">';
            echo '</div>';
            echo '<div class="usernameRecom">' .$username . '</div>';
        echo '</div>';
?>