<?php
    require("php/common.php");
    
    $query = "SELECT * FROM following";

    try{ 
		$stmt = $db->prepare($query); 
		$result = $stmt->execute(); 
	} 
	catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
	$posts = $stmt->fetchAll();
    
    $query = "INSERT INTO following (user_no, follower_id)  VALUES (:userid, :follower)"; 
		$query_params = array(':userid' => $_SESSION['user']['id'], ':follower' => intval($_GET['id']); 
	
        try{ 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 
                              
        echo '';
                              
?> 