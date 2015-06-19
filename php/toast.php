<?php
    require("common.php");
    header('Content-Type: application/json');

	$errors = array();
	$data = array();

    $query = "SELECT * FROM post_toasts WHERE pid = :postId AND uid= :userId"; 
    $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']); 
        
    $stmt = $db->prepare($query);
    $result = $stmt->execute($query_params); 
    $hasToasted = $stmt->rowCount();
    
    $query = "SELECT * FROM post_burns WHERE p_id = :postId AND u_id= :userId"; 
    $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']); 
        
    $stmt = $db->prepare($query);
    $result = $stmt->execute($query_params); 
    $hasBurnt = $stmt->rowCount();
    
    if ($hasBurnt) {
        if ($hasToasted) {
            $query = "DELETE FROM post_burns WHERE uid = :userId AND pid = :postId"; 
            $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
            
            $query = "UPDATE posts SET burns = burns-1 WHERE id = :postId"; 
            $query_params = array(':postId' => $_POST['post']); 
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
            
            $data['success'] = true;
            $data['removedBurn'] = true;
            $data['addedToast'] = false;
            
        } else {
            $query = "INSERT INTO post_toasts (pid, uid) VALUES(:postId, :userId)";
            $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);

            $query = "UPDATE posts SET toasts=toasts+1 WHERE id=:postId";
            $query_params = array(':postId' => $_POST['post']); 
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
            
            $query = "DELETE FROM post_burns WHERE u_id = :userId AND p_id = :postId"; 
            $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
            
            $query = "UPDATE posts SET burns = burns-1 WHERE id = :postId";
            $query_params = array(':postId' => $_POST['post']); 
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
            $query = "INSERT INTO post_toasts (pid, uid) VALUES(:postId, :userId)";
            $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);

            $query = "UPDATE posts SET toasts=toasts+1 WHERE id=:postId";
            $query_params = array(':postId' => $_POST['post']); 
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
            
            $data['success'] = true;
            $data['removedBurn'] = false;
            $data['addedToast'] = true;
        }
    }

?> 