<?php 
	header("Content-Type: application/json", true);
    require("common.php"); 
	require("vendor/ImageResize.php");
	
    $data = array();

    if(isset($_FILES["file"])) { //If post has an image...
        $imgInfo = getimagesize($_FILES['file']['tmp_name']);
        $width = $imgInfo[0];
        $height = $imgInfo[1];
        
        $updirectory = 'img/uploads/' . $_SESSION['user']['id'] . '/';
        $filename = strtolower($_FILES['file']['name']);
        $extension = '.jpg';
        
        if (!file_exists('../img/uploads/' . $_SESSION['user']['id'])) {
            mkdir('../img/uploads/' . $_SESSION['user']['id'], 0777, true);
        }        
        
        do {
            $rand = rand(0, 9999999999); 
            $newfile = $rand.$extension;
        } while (file_exists('../' . $updirectory . $newfile));
        
        if ($width > 640) {
            $uploadImage  = new ImageResize($_FILES['file']['tmp_name']);
            $uploadImage->quality_jpg = 75;
            $uploadImage->resizeToWidth(640);
            $uploadImage->save("../" . $updirectory.$newfile);
            
        } else {
            $uploadImage  = new ImageResize($_FILES['file']['tmp_name']);
            $uploadImage->quality_jpg = 75;
            $uploadImage->crop($width, $height);
            $uploadImage->save("../" . $updirectory.$newfile); 
        }
        
        if (file_exists("../" . $updirectory.$newfile )) {
            if (isset($_POST['text'])) {    
                $query = "INSERT INTO posts (userid, type, text, image)  VALUES (:userid, 'imagetext', :text, :image)"; 
                $query_params = array(':userid' => $_SESSION['user']['id'], ':text' => $_POST['text'], ':image' => $updirectory.$newfile); 

            } else {
                $query = "INSERT INTO posts (userid, type, image)  VALUES (:userid, 'image', :filename)"; 
                $query_params = array(':userid' => $_SESSION['user']['id'], ':filename' => $updirectory.$newfile); 
            }
            
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
            $data['success'] = true;

        } else {
            die("Error: Couldn't upload the file.");
            $data['success'] = false;
            $data['error'] = 'A problem was encountered uploading the image.';
        }
        
    } else if (isset($_POST['text'])) { //If post has only text...
        if (empty($_POST['text'])) {
            $data['success'] = false;
            $data['error'] = 'No text was found to post.';
            
        } else if (ctype_space($_POST['text'])) {
            $data['success'] = false;
            $data['error'] = 'Posts cannot contain only spaces.';
            
        } else {
            $query = "INSERT INTO posts (userid, type, text)  VALUES (:userid, 'text', :text)"; 
            $query_params = array(':userid' => $_SESSION['user']['id'], ':text' => $_POST['text']); 

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