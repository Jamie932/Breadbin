<?php
    header("Content-Type: application/json", true);
    require("common.php");

    function checkLength($s, $min, $max) {
		if (strlen($s) > $max) { return 2; }
		elseif (strlen($s) < $min) { return 1; }
		else { return 0; }
	};

    $data = array();
    $upEmail = true;

    if (!empty($_POST['firstname']) && ctype_space($_POST['firstname'])) {
        $data['success'] = false;
        $data['error'] = 'Your first name cannot contain spaces.'; 
    } else if (!empty($_POST['lastname']) && ctype_space($_POST['lastname'])) {
        $data['success'] = false;
        $data['error'] = 'Your last name cannot contain spaces.';   
    } else if (!empty($_POST['email'])) {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $data['success'] = false;
            $data['error'] = 'Your email address is invalid.';
        } else {
            $query = "SELECT * FROM users WHERE email = :email";
            $query_params = array(':email' => $_POST['email']); 
            
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
            $row = $stmt->fetch(); 
            
            if($row){                
                if ($row['email'] != $_SESSION['user']['email']) {
                    $data['success'] = false;
                    $data['error'] = 'This email address has already been registered.';
                } else {
                    $upEmail = false;
                }
            }  
        }
    }

    if ($data['success'] != false) {
        if ($upEmail) {
            $query = "UPDATE users SET 
                firstname = COALESCE(NULLIF(:firstname, ''),firstname), 
                lastname = COALESCE(NULLIF(:lastname, ''),lastname), 
                email = COALESCE(NULLIF(:email, ''),email)
                WHERE id = :id";
            
            $query_params = array( 
                ':firstname' => $_POST['firstname'], 
                ':lastname' => $_POST['lastname'], 
                ':email' => $_POST['email'],
                ':id' => $_SESSION['user']['id']
            );              
            
        } else {
            $query = "UPDATE users SET 
                firstname = COALESCE(NULLIF(:firstname, ''),firstname), 
                lastname = COALESCE(NULLIF(:lastname, ''),lastname)
                WHERE id = :id";
            
            $query_params = array( 
                ':firstname' => $_POST['firstname'], 
                ':lastname' => $_POST['lastname'],
                ':id' => $_SESSION['user']['id']
            );            
        }
        
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
        
        if ($_POST['colour'] && !empty($_POST['colour']) && $_POST['colour'] != '') {
            $query = "INSERT INTO user_settings (user_id, colour) VALUES (:id, :colour) ON DUPLICATE KEY UPDATE colour=:colour";
            $query_params = array( 
                ':colour' => $_POST['colour'], 
                ':id' => $_SESSION['user']['id']
            ); 

            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        }
        
        $data['success'] = true;
    }

    echo json_encode($data);
?>