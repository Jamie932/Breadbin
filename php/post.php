<?php 
    require("common.php"); 
	
	$errors = array();
	$data = array();
	
    if(isset($_FILES["upfile"]) && $_FILES["upfile"]["error"]== UPLOAD_ERR_OK) {
        $UploadDirectory    = '/img/uploads/';
        $File_Name          = strtolower($_FILES['upfile']['name']);
        $File_Ext           = substr($File_Name, strrpos($File_Name, '.'));
        $Random_Number      = rand(0, 9999999999); 
        $NewFileName        = $Random_Number.$File_Ext;
        
        if(move_uploaded_file($_FILES['FileInput']['tmp_name'], $UploadDirectory.$NewFileName )) {
            $query = "INSERT INTO posts (userid, type, text)  VALUES (:userid, 'image', :filename)"; 
            $query_params = array(':userid' => $_SESSION['user']['id'], ':filename' => $UploadDirectory.$NewFileName); 

            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
            
            die('Success! File Uploaded.');
        } else {
            die('error uploading File!');
        }
    else {
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