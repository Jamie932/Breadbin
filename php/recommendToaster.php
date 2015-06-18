<?php 
    require("php/common.php");

    $query = $db->query("SELECT * FROM users ORDER BY RAND() LIMIT 1");

    $stmt = $db->prepare($query); 
    $result = $stmt->execute($query_params); 
    $row = $stmt->fetch();

        if($row){ 
            $username = $row['username'];
        }

        echo '<div class="userRecom">';
            echo '<div class="usericoRecom">';
                echo '<img src="img/cat.jpg" height="50px" width="50px">';
            echo '</div>';
            echo '<div class="usernameRecom">' .$username . '</div>';
        echo '</div>';
?>