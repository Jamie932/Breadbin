<?php
    require("common.php");

    $query = "INSERT INTO following (user_no, follower_id)  VALUES (:userid, :follower)"; 
    $query_params = array(':userid' => $_POST['url'], ':follower' =>  $_SESSION['user']['id']); 
    $stmt = $db->prepare($query);
    $result = $stmt->execute($query_params);                       
?> 