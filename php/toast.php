<?php
    require("common.php");

    $sql=$db->prepare("SELECT * FROM likes WHERE pid = :postID and uid= :userId");
    $sql->execute(array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']));
    $matches=$sql->rowCount();
                  
    if($matches==0){
        $sql=$db->prepare("INSERT INTO likes (pid, user) VALUES(:postId, :userId)");
        $sql->execute(array(':postId' => $_POST['post'], ':userId' => $_SESSION['user']['id']));
        $sql=$db->prepare("UPDATE posts SET likes=likes+1 WHERE id=:postId");
        $sql->execute(array(':postId' => $_POST['post']));         
    }
?> 