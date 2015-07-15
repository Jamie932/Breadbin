<?php 
	header("Content-Type: application/json", true);
    require("common.php"); 
	require("vendor/ImageResize.php");
	
    $data = array();
    
    if (isset($_POST['title'])) { //If post has only text...
        if (empty($_POST['title'])) {
            $data['success'] = false;
            $data['error'] = 'Recipes need a title.';
            
        } else if (empty($_POST['ingredients'])) {
            $data['success'] = false;
            $data['error'] = 'Recipes need a ingredients.';
            
        } else if (empty($_POST['instructions'])) {
            $data['success'] = false;
            $data['error'] = 'Recipes need a instructions.';
            
        } else {
            $query = "INSERT INTO posts (userid, type, title)  VALUES (:userid, 'recipe', :text)"; 
            $query_params = array(':userid' => $_SESSION['user']['id'], ':title' => $_POST['title']); 

            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);

            $data['success'] = true;
        }
    } else {            
        $data['success'] = false;
        $data['error'] = 'Found nothing to post.';   
    }

    echo json_encode($data);
?> 