<?php
    require("common.php");

    $query = "DELETE FROM following WHERE :follower = :id"; 
    $query_params = array(':id' => $_POST['url'], ':follower' =>  $_SESSION['user']['id']);
    $stmt = $db->prepare($query); 
    $result = $stmt->execute($query_params);                       
?> 