<?php 
	header("Content-Type: application/json", true);
    require("../common.php"); 
	
	$data = array();
	
    if (empty($_POST['post'])) {
        $data['success'] = false;
        $data['error']  = 'No PostID was found.';
        
	} else if ($_SESSION['user']['rank'] != 'owner' && $_SESSION['user']['rank'] != 'admin') {
		$data['success'] = false;
		$data['error']  = 'You do not have the correct permissions to do this.';
		
	} else {
        $query = "UPDATE posts SET favourite = NOT favourite WHERE id = :id"; 
        $query_params = array(':id' => $_POST['post']); 

        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);

        $data['success'] = true;
    }

    echo json_encode($data);
?> 