<?php
    require("common.php");
                  
    $query = "SELECT * FROM likes WHERE pid = :postId AND uid= :userId"; 
    $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']); 
        
    $stmt = $db->prepare($query);
    $result = $stmt->execute($query_params); 
    $matches = $stmt->rowCount();
    
    $query = "SELECT * FROM burns WHERE p_id = :postId AND u_id= :userId"; 
    $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']); 
        
    $stmt = $db->prepare($query);
    $result = $stmt->execute($query_params); 
    $ifBurnt = $stmt->rowCount();
    
    if($ifBurnt==0) {
        if($matches==0){
            $query = "INSERT INTO likes (pid, uid) VALUES(:postId, :userId)";
            $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);

            $query = "UPDATE posts SET likes=likes+1 WHERE id=:postId";
            $query_params = array(':postId' => $_POST['post']); 
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        } else {
            echo 'Soz luv. You already toasted this fucker.';
        }
    } else {
        if($matches==0){
            $query = "INSERT INTO likes (pid, uid) VALUES(:postId, :userId)";
            $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);

            $query = "UPDATE posts SET likes=likes+1 WHERE id=:postId";
            $query_params = array(':postId' => $_POST['post']); 
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
            
            $query = "DELETE FROM burns WHERE u_ui = :userId AND p_ui = :postId"; 
            $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
            
            $query = "UPDATE posts SET burns=burns-1 WHERE id=:postId";
            $query_params = array(':postId' => $_POST['post']); 
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
            
        } else {
            echo 'Soz luv. You already toasted this fucker. REMOVED BURN';
        }
    }
?> 