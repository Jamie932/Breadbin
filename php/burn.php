<?php
    require("common.php");
                  
    $query = "SELECT * FROM burns WHERE p_id = :postId AND u_id= :userId"; 
    $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']); 
        
    $stmt = $db->prepare($query);
    $result = $stmt->execute($query_params); 
    $row = $stmt->rowCount();

    $query = "SELECT * FROM likes WHERE pid = :postId AND uid= :userId"; 
    $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
        
    $stmt = $db->prepare($query);
    $result = $stmt->execute($query_params); 
    $ifToasted = $stmt->rowCount();

    if($ifToasted==0) {
        if($matches==0){
            $query = "INSERT INTO burns (p_id, u_id) VALUES(:postId, :userId)";
            $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);

            $query = "UPDATE posts SET burns=burns+1 WHERE id = :postId";
            $query_params = array(':postId' => $_POST['post']); 
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        } else {
            echo 'Burn no like';
        }
    } else {
        if($matches==0){
           $query = "INSERT INTO burns (p_id, u_id) VALUES(:postId, :userId)";
            $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);

            $query = "UPDATE posts SET burns=burns+1 WHERE id = :postId";
            $query_params = array(':postId' => $_POST['post']); 
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        
            $query = "DELETE FROM likes WHERE uid = :userId AND pid = :postId"; 
            $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
            
            $query = "UPDATE posts SET likes = likes-1 WHERE id = :postId"; 
            $query_params = array(':postId' => $_POST['post']); 
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        } else {
            echo 'Burn but liked';  
        }
    } 
?> 