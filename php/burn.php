<?php
    require("common.php");
      
	$errors = array();
	$data = array();

    $query = "SELECT * FROM post_burns WHERE p_id = :postId AND u_id= :userId"; 
    $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']); 
        
    $stmt = $db->prepare($query);
    $result = $stmt->execute($query_params); 
    $hasBurnt = $stmt->rowCount();

    $query = "SELECT * FROM post_toasts WHERE pid = :postId AND uid= :userId"; 
    $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
        
    $stmt = $db->prepare($query);
    $result = $stmt->execute($query_params); 
    $hasToasted = $stmt->rowCount();

    if($hasToasted) {
        if($hasBurnt){
            $query = "DELETE FROM post_toasts WHERE uid = :userId AND pid = :postId"; 
            $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
            
            $query = "UPDATE posts SET toasts = toasts-1 WHERE id = :postId"; 
            $query_params = array(':postId' => $_POST['post']); 
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
            
            $data['success'] = true;
            $data['removedToast'] = true;
            $data['addedBurn'] = false;
            
        } else {
            $query = "INSERT INTO post_burns (p_id, u_id) VALUES(:postId, :userId)";
            $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);

            $query = "UPDATE posts SET burns=burns+1 WHERE id = :postId";
            $query_params = array(':postId' => $_POST['post']); 
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        
            $query = "DELETE FROM post_toasts WHERE uid = :userId AND pid = :postId"; 
            $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
            
            $query = "UPDATE posts SET toasts = toasts-1 WHERE id = :postId"; 
            $query_params = array(':postId' => $_POST['post']); 
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
            
            $data['success'] = true;
            $data['removedToast'] = true;
            $data['addedBurn'] = true;
        }
    } else {
        if($hasBurnt){
            $data['success'] = false;
        } else {
            $query = "INSERT INTO post_burns (p_id, u_id) VALUES(:postId, :userId)";
            $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);

            $query = "UPDATE posts SET burns=burns+1 WHERE id = :postId";
            $query_params = array(':postId' => $_POST['post']); 
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
            
            $data['success'] = true;
            $data['removedToast'] = false;
            $data['addedBurn'] = true;
        }
    }

    echo json_encode($data);

?> 