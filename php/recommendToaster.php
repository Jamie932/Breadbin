<?php 
    require("php/common.php");

    $sth = $pdo->prepare("SELECT * FROM users");
    $sth->execute();
    $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    $rowcount = $rows[0]['total_count'];
    
    $pdo->prepare("SELECT * FROM tablename WHERE id = :rows");
        $query_params = array(':rows' => $rowcount); 

        $result = $db->prepare($query); 
        $result->execute($query_params); 
        $noOfFollowers = $result->fetchColumn(); 

    if($result){ 
        $username = $row['username'];
        
    }

        echo '<div class="userRecom">';
            echo '<div class="usericoRecom">';
                echo '<img src="img/cat.jpg" height="50px" width="50px">';
            echo '</div>';
            echo '<div class="usernameRecom">' .$username . '</div>';
        echo '</div>';
?>