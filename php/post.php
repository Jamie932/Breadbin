<?php 
	header("Content-Type: application/json", true);
    require("common.php"); 
	
	$errors = array();
	$data = array();
                          
    if (ctype_space($_POST['ext'])) {
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
    } else if(empty($_POST['text'], $_POST['imagePost'])) {
        echo 'looool sucka';
    }
                          
    echo json_encode($data);
?> 