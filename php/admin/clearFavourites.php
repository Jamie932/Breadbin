<?php 
	header("Content-Type: application/json", true);
    require("../common.php"); 
	
	$data = array();
	
    if ($_SESSION['user']['rank'] != 'owner' && $_SESSION['user']['rank'] != 'admin') {
		$data['success'] = false;
		$data['error']  = 'You do not have the correct permissions to do this.';
		
	} else {
        $query = "UPDATE posts SET favourite = 0"; 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute();

        $data['success'] = true;
    }

    echo json_encode($data);
?> 