<?php 
	header("Content-Type: application/json", true);
    require("common.php"); 
	
	$errors = array();
	$data = array();
	
    if (empty($_POST['post'])) {
        $errors['post'] = 'A PostID is required!';
    }
	
	if (!empty($errors)) {
        $data['success'] = false;
        $data['errors']  = $errors;
		
    } else {
        $query = "SELECT * FROM posts WHERE id = :id"; 
        $query_params = array(':id' => $_POST['post']); 

        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);   
        $row = $stmt->fetch();
        
        if ($row) {
            if ($row['userid'] != $_SESSION['user']['id'] {
                $data['success'] = false;
                return false;
            }
            
            if (($row['type'] == 'image') || ($row['type'] == 'imagetext')) {
                if (file_exists($row['image'])) {
                    unlink($row['image']);
                } else {
                    $data['success'] = false;
                    $data['bollocks'] = true;
                }
            }
            
            $query = "DELETE FROM posts WHERE id = :id"; 
            $query_params = array(':id' => $_POST['post']); 

            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 

            $data['success'] = true;
        }
    }

    echo json_encode($data);
?> 