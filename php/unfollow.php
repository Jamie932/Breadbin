<?php
    require("common.php");
    
    $query = "DELETE FROM following WHERE user_no = :id AND follow_id = :follower"; 
    $query_params = array(':id' => $_POST['url'], ':follower' =>  $_SESSION['user']['id']);
    $stmt = $db->prepare($query); 
    $result = $stmt->execute($query_params);                       
?> 