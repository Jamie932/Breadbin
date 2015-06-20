<?php 
    require("common.php"); 
	
	$errors = array();
	$data = array();
	
    if(isset($_FILES["file"]) && $_FILES["file"]["error"]== UPLOAD_ERR_OK) {
        $updirectory = getcwd().DIRECTORY_SEPARATOR . '/img/uploads/';
        $filename = strtolower($_FILES['file']['name']);
        $extension = substr($filename, strrpos($filename, '.'));
        $rand = rand(0, 9999999999); 
        $newfile = $rand.$extension;
        
        if(move_uploaded_file($_FILES['file']['tmp_name'], $updirectory.$newfile )) {
            $query = "INSERT INTO posts (userid, type, image)  VALUES (:userid, 'image', :filename)"; 
            $query_params = array(':userid' => $_SESSION['user']['id'], ':filename' => $updirectory.$newfile); 

            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
            
            die('Success! File Uploaded.');
            echo 'wooooo.';
            
        } else {
            echo 'Well shit.';
            die('error uploading File!');
        }
    } else {
        if (empty($_POST['text'])) { 
            $errors['text'] = 'Text is required.';
        } else if (ctype_space($_POST['text'])) {
            $errors['text'] = 'Just spaces aren\'t allowed.';
        } else {
            $query = "INSERT INTO posts (userid, type, text)  VALUES (:userid, 'text', :text)"; 
            $query_params = array(':userid' => $_SESSION['user']['id'], ':text' => $_POST['text']); 

            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);

            $data['success'] = true;
            $data['message'] = 'Success!';
        }
    }
?> 