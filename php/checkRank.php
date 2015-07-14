<?php 
    $query = "SELECT id, rank FROM users WHERE id = :userid"; 
    $query_params = array(':userid' => $_SESSION['user']['id']); 

    $stmt = $db->prepare($query); 
    $result = $stmt->execute($query_params); 
    $row = $stmt->fetch();

    if ($row) {
        if (empty($row['rank']) || $row['rank'] == "user") {
            header('Location: errorFile.php?error=403');
        }
    }
?> 