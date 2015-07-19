<?php 
	header("Content-Type: application/json", true);
    require("common.php"); 
	
	$data = array();
	
    if (empty($_POST['post'])) {
        $data['success'] = false;
        $data['error']  = 'No PostID was found.';
        
    } else {
        $query = "SELECT * FROM posts WHERE id = :id"; 
        $query_params = array(':id' => $_POST['post']); 

        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);   
        $row = $stmt->fetch();

        if ($row) {
            if ($row['userid'] != $_SESSION['user']['id']) {
                $data['success'] = false;
                $data['error']  = 'This post does not belong to you.';
                return false;
            }

            if (($row['type'] == 'image') || ($row['type'] == 'imagetext')) {
                if (file_exists($row['image'])) {
                    $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row['image']);
                    $imageLocation = $withoutExt . '-profile.jpg';
                    
                    unlink($row['image']);
                    unlink($imageLocation);
                }
            }

            $query = "DELETE FROM posts WHERE id = :id"; 
            $query_params = array(':id' => $_POST['post']); 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 

            $query = "DELETE FROM post_burns WHERE postid = :id"; 
            $query_params = array(':id' => $_POST['post']); 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
			
            $query = "DELETE FROM post_toasts WHERE postid = :id"; 
            $query_params = array(':id' => $_POST['post']); 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
			
            $data['success'] = true;
        } else {
			$data['success'] = false;
			$data['error']  = 'An invalid PostID was provided.';
		}
    }

    echo json_encode($data);
?> 