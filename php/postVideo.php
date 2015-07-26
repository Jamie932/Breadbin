<?php 
	header("Content-Type: application/json", true);
    require("common.php"); 
	
    $data = array();

        if (empty($_POST['videoLink'])) {
            $data['success'] = false;
            $data['error'] = 'Recipes need a video.';
            
        } else if (ctype_space($_POST['videoLink'])) {
            $data['success'] = false;
            $data['error'] = 'Video cannot contain only spaces.';

        } else {
            
            $query = "INSERT INTO posts (userid, type, text)  VALUES (:userid, 'video', :text)"; 
            $query_params = array(':userid' => $_SESSION['user']['id'], ':text' => $_POST['videoLink']); 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);

            $data['success'] = true;
            
        }

    echo json_encode($data);

?> 