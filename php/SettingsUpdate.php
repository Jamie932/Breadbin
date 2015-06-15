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

    $query_params = array( 
            ':firstname' => $_POST['firstname'], 
            ':lastname' => $_POST['lastname'], 
            ':email' => $_POST['email'],
            ':id' => $_SESSION['user']['id']
        ); 

    // Checking for errors.
    if (!empty($_POST['firstname'])) {  
        if (checkLength($_POST['firstname'], 1,15) > 0) {
            $errors['firstname'] = '1-15 characters required.';
        } else {
            $query = "UPDATE users SET firstname = :firstname WHERE id = :id";
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        }
    }

    if (!empty($_POST['lastname'])) {
        if (checkLength($_POST['lastname'], 1,15) > 0) {
            $errors['lastname'] = '1-15 characters required.';
        } else {
            $query = "UPDATE users SET lastname = :lastname WHERE id = :id";
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        }
    }
	
	
    if (!empty($errors)) { // Were any errors found? If so do not continue and feed back the errors to HTML.
        $data['success'] = false;
        $data['errors']  = $errors;

        
        $data['success'] = true;
        $data['message'] = 'Success!';

    echo json_encode($data);
?>