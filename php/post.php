<?php 
	header("Content-Type: application/json", true);
    require("common.php"); 
	
	$errors = array();
	$data = array();
	
    if (empty($_POST['text'])) { 
        $errors['text'] = 'Text is required.';
	}
	
	if (!empty($errors)) {
        $data['success'] = false;
        $data['errors']  = $errors;
		
    } else {
	    $query = "INSERT INTO posts (userid, type, text)  VALUES (:userid, 'text', :text)"; 
		$query_params = array(':userid' => $_SESSION['user']['id'], ':text' => $_POST['text']); 
	
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