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
    $str = '      ';

    if (!empty($_POST['firstname'])) {
        if(ctype_space($_POST['firstname'])) {
            $errors['firstname'] = 'Firstname can\'t have spaces.';  
        }
    }

    if (!empty($_POST['lastname'])) {
        if(ctype_space($_POST['lastname'])) {
            $errors['lastname'] = 'Lastname can\'t have spaces.';  
        }
    }

    if (!empty($_POST['email'])) {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'The specified email is not valid.';
	} else {
       $query = "SELECT 1 FROM users WHERE email = :email";
       $query_params = array(':email' => $_POST['email']); 
        try { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage());} 
		
        $row = $stmt->fetch(); 
            if($row){ $errors['email'] = 'This email address is already registered.'; }
	   }
    }

    if (!empty($errors)) { // Were any errors found? If so do not continue and feed back the errors to HTML.
        $data['success'] = false;
        $data['errors']  = $errors;
        
    } else {
    
        /*$query = "UPDATE users SET 
            firstname = COALESCE(NULLIF(:firstname, ''),firstname), 
            lastname = COALESCE(NULLIF(:lastname, ''),lastname), 
            email = COALESCE(NULLIF(:email, ''),email)
            WHERE id = :id";
        
        $query_params = array( 
            ':firstname' => $_POST['firstname'], 
            ':lastname' => $_POST['lastname'], 
            ':email' => $_POST['email'],
            ':id' => $_SESSION['user']['id']
        );*/ 
        
        $query = "INSERT INTO user_settings (user_id, colour) VALUES (:id, :colour) ON DUPILICATE KEY UPDATE colour = :colour";

        $query_params = array( 
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
    }

    echo json_encode($data);
?>