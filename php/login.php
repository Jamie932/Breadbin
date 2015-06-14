<?php 
	header("Content-Type: application/json", true);
    require("common.php"); 
	
    $submitted_username = '';
	$errors = array();
	$data = array();
	
    if (empty($_POST['username'])) { 
        $errors['username'] = 'A username is required.';
	}
	
	if (empty($_POST['password'])) {
        $errors['password'] = 'A password is required.';
	}
	
	if (!empty($errors)) {
        $data['success'] = false;
        $data['errors']  = $errors;
		
    } else {
	    $query = "SELECT id, username, password, salt, email FROM users WHERE username = :username"; 
		$query_params = array(':username' => $_POST['username']); 
	
        try{ 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 
        $login_ok = false; 
        $row = $stmt->fetch();
		
        if($row){ 
            $check_password = hash('sha256', $_POST['password'] . $row['salt']); 
            for($round = 0; $round < 65536; $round++){
                $check_password = hash('sha256', $check_password . $row['salt']);
            } 
            if($check_password === $row['password']){
                $login_ok = true;
            } 
        } 
 
        if($login_ok){ 
            unset($row['salt']); 
            unset($row['password']); 
            $_SESSION['user'] = $row;  
			
			$data['success'] = true;
			$data['message'] = 'Success!';
        } 
        else{ 
            print("Login Failed."); 
            $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8'); 			
			
			$data['success'] = false;
			$data['incorrect'] = true;
        } 
	
    }

    echo json_encode($data);
?> 