<?php
	header("Content-Type: application/json", true);
    require("common.php");
	
	function checkLength($s, $min, $max) {
		if (strlen($s) > $max) { return 2; }
		elseif (strlen($s) < $min) { return 1; }
		else { return 0; }
	};

	$errors = array();
	$data = array();
	
	// Checking for errors.
    if (empty($_POST['username'])) {  
        $errors['username'] = 'A username is required.';
	} else if (checkLength($_POST['username'], 5,20) > 0) {
        $errors['username'] = '5-20 characters required.';
	} else {
		$query = "SELECT 1 FROM users WHERE username = :username";
        $query_params = array(':username' => $_POST['username']); 
        
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
		$row = $stmt->fetch(); 
        
		if($row){ $errors['username'] = 'This username is already in use.'; }
	}
	
	if (empty($_POST['password'])) {
        $errors['password'] = 'A password is required.'; 
	} else if($_POST['password'] != $_POST['confirmPassword']) {
        $errors['password'] = 'Passwords do not match.';
        $errors['confirmPassword'] = 'Passwords do not match.';
	}
	
    if (empty($_POST['email'])) {
        $errors['email'] = 'An email is required.';
	} else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'The specified email is not valid.';
	} else {
       $query = "SELECT 1 FROM users WHERE email = :email";
       $query_params = array(':email' => $_POST['email']); 
        
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
        $row = $stmt->fetch(); 
        
		if($row){ $errors['email'] = 'This email address is already registered.'; }
	}
	
    if (!empty($errors)) { // Were any errors found? If so do not continue and feed back the errors to HTML.
        $data['success'] = false;
        $data['errors']  = $errors;
		
    } else { //If not then add the user wooo
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
        $password = hash('sha256', $_POST['password'] . $salt); 
        for($round = 0; $round < 65536; $round++){ $password = hash('sha256', $password . $salt); } 
		
        $query = "INSERT INTO users (username, password, salt, email) VALUES (:username, :password, :salt, :email);";
        $query_params = array( 
            ':username' => $_POST['username'], 
            ':password' => $password, 
            ':salt' => $salt, 
            ':email' => $_POST['email'] 
        ); 
        
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);
	
        $data['success'] = true;
        $data['message'] = 'Success!';
    }

    echo json_encode($data);
?>