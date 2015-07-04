<?php 
    require("common.php"); 
	require("ImageResize.class.php");

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
        
        $UploadAvatar  = new ImageResize('file');
        $UploadResult = $UploadAvatar->Resize(150, $updirectory . $newfile, 100);
        
        if($UploadResult) {   
            echo $updirectory . $newfile;
            die('Success: Avatar uploaded.');
        } else {
            die("Error: Couldn't upload the avatar.");
        }
        
    } else {
        die('Error: Nothing found to upload.');   
    }
?> 