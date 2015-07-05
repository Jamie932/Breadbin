<?php 
    require("common.php"); 

    if(isset($_FILES["file"])) {
        $updirectory = '../img/avatars/' . $_SESSION['user']['id'] . '/';
        $filename = strtolower($_FILES['file']['name']);
        $extension = ".jpg";
        $newfile = "avatar".$extension;
        
        if (!file_exists('../img/avatars/' . $_SESSION['user']['id'])) {
            mkdir('../img/avatars/' . $_SESSION['user']['id'], 0777, true);
        } else {
            if(file_exists($updirectory . $newfile)) { 
                unlink($updirectory . $newfile);
            }
        }
        
        if(move_uploaded_file($_FILES['file']['tmp_name'], $updirectory.$newfile )) {
            list($width, $height) = getimagesize( $updirectory.$newfile );
            $response = array(
                "status" => 'success',
                "url" => 'img/avatars/' . $_SESSION['user']['id'] . '/' . $newfile,
                "width" => $width,
                "height" => $height
		      );
            
        } else {
           $response = array(
                "status" => 'error',
                "message" => 'Couldnt upload the avatar! Please report this error.',
            );
        }
        
    } else {           
        $response = array(
            "status" => 'error',
            "message" => 'No file found.',
        );  
    }

    print json_encode($response);
?> 