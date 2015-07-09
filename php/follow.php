<?php
	header("Content-Type: application/json", true);
    require("common.php");

    $data = array();

    if (!isset($_POST['url'])) {
        $data['success'] = false;
        $data['error'] = 'The follow request was empty.';
        
    } else if ($_POST['url'] == $_SESSION['user']['id']) {
        $data['success'] = false;
        $data['error'] = 'You cannot follow yourself.';
        
    } else {
        $query = "INSERT INTO following (user_no, follower_id)  VALUES (:userid, :follower)"; 
        $query_params = array(':userid' => $_POST['url'], ':follower' =>  $_SESSION['user']['id']); 
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);      
        
        $data['success'] = true;                
    }

 echo json_encode($data);
?> 