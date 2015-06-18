<?php 
    require("php/common.php");

    $query = "SELECT count(*) FROM users"; 
        $result = $db->prepare($query); 
        $result->execute();
        $usersCount = $result->fetchColumn(); 

        echo '<div class="userRecom">';
            echo '<div class="usericoRecom">';
                echo '<img src="img/cat.jpg" height="50px" width="50px">';
            echo '</div>';
            echo '<div class="usernameRecom">' .$usersCount . '</div>';
        echo '</div>';
?>