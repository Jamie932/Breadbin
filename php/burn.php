<?php
	header("Content-Type: application/json", true);
    require("common.php");
      
	$data = array();

    $query = "SELECT * FROM post_burns WHERE postid = :postId AND userid = :userId"; 
    $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']); 
        
    $stmt = $db->prepare($query);
    $result = $stmt->execute($query_params); 
    $hasBurnt = $stmt->rowCount();

    $query = "SELECT * FROM post_toasts WHERE postid = :postId AND userid = :userId"; 
    $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
        
    $stmt = $db->prepare($query);
    $result = $stmt->execute($query_params); 
    $hasToasted = $stmt->rowCount();

    if($hasToasted) {
        if($hasBurnt){
            $query = "DELETE FROM post_toasts WHERE userid = :userId AND postid = :postId"; 
            $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
            
            $data['success'] = true;
            $data['removedToast'] = true;
            $data['addedBurn'] = false;
            
        } else {
            $query = "INSERT INTO post_burns (postid, userid) VALUES(:postId, :userId)";
            $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);

            $query = "DELETE FROM post_toasts WHERE userid = :userId AND postid = :postId"; 
            $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
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
            $query = "INSERT INTO post_burns (postid, userid) VALUES(:postId, :userId)";
            $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
			
            $data['success'] = true;
            $data['removedToast'] = false;
            $data['addedBurn'] = true;
        }
    }

    echo json_encode($data);

?> 