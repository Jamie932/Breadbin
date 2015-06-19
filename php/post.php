<?php 
	header("Content-Type: application/json", true);
    require("common.php"); 
	
	$errors = array();
	$data = array();
	
    if (empty($_POST['text'])) { 
        $errors['text'] = 'Text is required.';
    } else if (ctype_space($_POST['text'])) {
        $errors['text'] = 'Just spaces aren\'t allowed.';
    }
	
	if (!empty($errors)) {
        $data['success'] = false;
        $data['errors']  = $errors;
		
    } else {
	    $query = "INSERT INTO posts (userid, type, text)  VALUES (:userid, 'text', :text)"; 
		$query_params = array(':userid' => $_SESSION['user']['id'], ':text' => $_POST['text']); 
	
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);
			
        $data['success'] = true;
        $data['message'] = 'Success!';
    }

    echo json_encode($data);
?> 