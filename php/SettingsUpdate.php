<?php

    header("Content-Type: application/json", true);
    require("../php/common.php");

    $data = array();

    $query = "UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email WHERE id = :id";
    $query = "UPDATE user_settings SET colour = :colour WHERE id = :id";
        $query_params = array( 
            ':firstname' => $_POST['firstname'], 
            ':lastname' => $_POST['lastname'], 
            ':email' => $_POST['email'],
            ':colour' => $_POST['colour'],
            ':id' => $_SESSION['user']['id']
        ); 
        try {  
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 
	
        $data['success'] = true;
        $data['message'] = 'Success!';

    echo json_encode($data);
?>