<?php 
	header("Content-Type: application/json", true);
    require("common.php"); 
	
	$errors = array();
	$data = array();
	
    if (empty($_POST['text'])) { 
        $errors['text'] = 'A username is required.';
	}

    if (empty($_POST['userid'])) {
        $errors['userid'] = 'Unable to find UserID.';
    }
	
	if (!empty($errors)) {
        $data['success'] = false;
        $data['errors']  = $errors;
		
    } else {
	    $query = "INSERT INTO posts (userid, type, text)  VALUES (:userid, 'text', :text)"; 
		$query_params = array(':userid' => $_POST['userid'], ':text' => $_POST['text']); 
	
        try{ 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 
			
        $data['success'] = true;
        $data['message'] = 'Success!';
	
    }

    echo json_encode($data);
?> 