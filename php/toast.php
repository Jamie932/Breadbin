<?php
    require("common.php");
                  
    $query = "SELECT * FROM likes WHERE pid = :postID AND uid= :userId"; 
    $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']); 
        
    $stmt = $db->prepare($query); 
    $result = $stmt->execute($query_params); 
    $row = $stmt->rowCount();

    if($matches==0){
        $query = "INSERT INTO likes (pid, user) VALUES(:postId, :userId)";
        $query_params = array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']);
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
        
        $query = "UPDATE posts SET likes=likes+1 WHERE id=:postId";
        $query_params = array(':postId' => $_POST['post']); 
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
?> 