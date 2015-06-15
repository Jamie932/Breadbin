<?php 
	header("Content-Type: application/json", true);
    require("common.php"); 

    $hash = $_COOKIE['hashkey'];

    $query = "DELETE FROM uniquelogs WHERE hash = :hash";
    $query_params = array(':hash' => $hash); 

    try{
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
    }
    catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }

    unset($hash);
?> 