<?php 
    require("php/common.php");

    $query = "SELECT username FROM users ORDER BY RAND() LIMIT 1"; 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute(); 

        echo '<div class="userRecom">';
            echo '<div class="usericoRecom">';
                echo '<img src="img/cat.jpg" height="50px" width="50px">';
            echo '</div>';
            echo '<div class="usernameRecom">' .$result . '</div>';
        echo '</div>';
?>