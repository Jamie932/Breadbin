<?php 
    header('Content-Type: text/plain; charset=utf-8');
    require("common.php"); 
	
	$errors = array();
	$data = array();
	
    if(isset($_FILES["file"])) {
        try {
            
        if (!isset($_FILES['file']['error']) || is_array($_FILES['file']['error'])) {
            throw new RuntimeException('Invalid parameters.');
        }

        switch ($_FILES['file']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException('No file sent.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException('Exceeded filesize limit.');
            default:
                throw new RuntimeException('Unknown errors.');
        }

        if ($_FILES['file']['size'] > 1000000) {
            throw new RuntimeException('Exceeded filesize limit.');
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search(
            $finfo->file($_FILES['file']['tmp_name']),
            array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            ),
            true
        )) {
            throw new RuntimeException('Invalid file format.');
        }

        // You should name it uniquely.
        // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
        // On this example, obtain safe unique name from its binary data.
        if (!move_uploaded_file($_FILES['file']['tmp_name'], sprintf('./uploads/%s.%s', sha1_file($_FILES['file']['tmp_name']), $ext))) {
            throw new RuntimeException('Failed to move uploaded file.');
        }

        echo 'File is uploaded successfully.';
            
        $query = "INSERT INTO posts (userid, type, image)  VALUES (:userid, 'image', :imgurl)"; 
        $query_params = array(':userid' => $_SESSION['user']['id'], ':imgurl' => sprintf('./uploads/%s.%s', sha1_file($_FILES['file']['tmp_name']), $ext)); 

        } catch (RuntimeException $e) {
            echo $e->getMessage();
        }

    } else {
        echo 'hi';
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