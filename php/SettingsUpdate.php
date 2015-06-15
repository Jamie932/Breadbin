<?php
    header("Content-Type: application/json", true);
    require("../php/common.php");

    function checkLength($s, $min, $max) {
		if (strlen($s) > $max) { return 2; }
		elseif (strlen($s) < $min) { return 1; }
		else { return 0; }
	};

    $data = array();
    $errors = array();

        $query = "UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email WHERE id = :id";
        
        $query_params = array( 
            ':firstname' => $_POST['firstname'], 
            ':lastname' => $_POST['lastname'], 
            ':email' => $_POST['email'],
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