<?php
	header("Content-Type: application/json", true);
    require("common.php");

	$data = array();

    $query = "SELECT * FROM post_toasts WHERE postid = :postId AND userid= :userId"; 
    $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']); 
        
    $stmt = $db->prepare($query);
    $result = $stmt->execute($query_params); 
    $hasToasted = $stmt->rowCount();
    
    $query = "SELECT * FROM post_burns WHERE postid = :postId AND userid = :userId"; 
    $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']); 
        
    $stmt = $db->prepare($query);
    $result = $stmt->execute($query_params); 
    $hasBurnt = $stmt->rowCount();
    
    if ($hasBurnt) {
        if ($hasToasted) {
            $query = "DELETE FROM post_burns WHERE userid = :userId AND postid = :postId"; 
            $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
                        
            $data['success'] = true;
            $data['removedBurn'] = true;
            $data['addedToast'] = false;
            
        } else {
            $query = "INSERT INTO post_toasts (postid, userid) VALUES(:postId, :userId)";
            $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
            
            $query = "DELETE FROM post_burns WHERE userid = :userId AND postid = :postId"; 
            $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
                        
            $data['success'] = true;
            $data['removedBurn'] = true;
            $data['addedToast'] = true;
        }
        
    } else {
        if ($hasToasted) {
            $data['success'] = false;
        } else {
            $query = "INSERT INTO post_toasts (postid, userid) VALUES(:postId, :userId)";
            $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
            
            $data['success'] = true;
            $data['removedBurn'] = false;
            $data['addedToast'] = true;
        }
    }

    echo json_encode($data);

?> 