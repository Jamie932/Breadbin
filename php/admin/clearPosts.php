<?php 
	header("Content-Type: application/json", true);
    require("../common.php"); 
	
	$data = array();
	
	function recursiveRemoveDirectory($directory) {
		foreach(glob("{$directory}/*") as $file) {
			if(is_dir($file)) { 
				recursiveRemoveDirectory($file);
			} else {
				unlink($file);
			}
		}
		//rmdir($directory);
	}

    if ($_SESSION['user']['rank'] != 'owner' && $_SESSION['user']['rank'] != 'admin') {
		$data['success'] = false;
		$data['error']  = 'You do not have the correct permissions to do this.';
		
	} else {
        $query = "TRUNCATE posts"; 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute();

		recursiveRemoveDirectory('../../img/uploads');
		
        $data['success'] = true;
    }

    echo json_encode($data);
?> 