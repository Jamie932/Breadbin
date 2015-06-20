<?php 
    require("common.php"); 
	
    if(isset($_FILES["file"]) && isset($_POST['text'])) { //If post has text AND an image...
        $updirectory = '../img/uploads/' . $_SESSION['user']['id'] . '/';
        $filename = strtolower($_FILES['file']['name']);
        $extension = substr($filename, strrpos($filename, '.'));
        $rand = rand(0, 9999999999); 
        $newfile = $rand.$extension;
        
        if (!file_exists('../img/uploads/' . $_SESSION['user']['id'])) {
            mkdir('../img/uploads/' . $_SESSION['user']['id'], 0777, true);
        }
        
        if(move_uploaded_file($_FILES['file']['tmp_name'], $updirectory.$newfile )) {
            $query = "INSERT INTO posts (userid, type, text, imgurl)  VALUES (:userid, 'imagetext', :text, :imgurl)"; 
            $query_params = array(':userid' => $_SESSION['user']['id'], ':text' => $_POST['text'], ':imgurl' => $updirectory.$newfile); 

            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
            
            die('Success: File Uploaded.');
            
        } else {
            die("Error: Couldn't upload the file.");
        }
        
    } else if (isset($_FILES["file"])) {  //If post has only an image...
        $updirectory = '../img/uploads/' . $_SESSION['user']['id'] . '/';
        $filename = strtolower($_FILES['file']['name']);
        $extension = substr($filename, strrpos($filename, '.'));
        $rand = rand(0, 9999999999); 
        $newfile = $rand.$extension;
        
        if (!file_exists('../img/uploads/' . $_SESSION['user']['id'])) {
            mkdir('../img/uploads/' . $_SESSION['user']['id'], 0777, true);
        }
        
        if(move_uploaded_file($_FILES['file']['tmp_name'], $updirectory.$newfile )) {
            $query = "INSERT INTO posts (userid, type, image)  VALUES (:userid, 'image', :filename)"; 
            $query_params = array(':userid' => $_SESSION['user']['id'], ':filename' => $updirectory.$newfile); 

            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
            
            die('Success: File Uploaded.');
            
        } else {
            die("Error: Couldn't upload the file.");
        }
    } else if (isset($_POST['text'])) { //If post has only text...
        if (empty($_POST['text'])) { 
            die('Error: Text is empty.');
        } else if (ctype_space($_POST['text'])) {
            die('Error: Text cannot be only spaces.');
        } else {
            $query = "INSERT INTO posts (userid, type, text)  VALUES (:userid, 'text', :text)"; 
            $query_params = array(':userid' => $_SESSION['user']['id'], ':text' => $_POST['text']); 

            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);

            die('Success: File Uploaded.');
        }
    } else {
        die('Error: Found nothing to post.');   
    }
?> 