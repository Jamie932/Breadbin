<?php
    require("common.php");
    
    $query = "SELECT * FROM following";

    try{ 
		$stmt = $db->prepare($query); 
		$result = $stmt->execute(); 
	} 
	catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
	$posts = $stmt->fetchAll();
    
    $query = "INSERT INTO following (user_no, follower_id)  VALUES (:userid, :follower)"; 
		$query_params = array(':userid' => intval($_GET['id']), ':follower' =>  $_SESSION['user']['id']); 
	
        try{ 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 
                              
        echo '';
                              
?> 