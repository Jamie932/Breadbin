<?php 
	header("Content-Type: application/json", true);
    require("common.php");

    $query = "DELETE FROM uniquelogs WHERE hash = :hash";
    $query_params = array(':hash' => $hash); 

    $stmt = $db->prepare($query); 
    $result = $stmt->execute($query_params); 

    unset($_COOKIE['hashkey']);
    unset($_SESSION['user']);
    setcookie('hashkey', '', time() - 3600, '/', '.yourmums.science');
?> 