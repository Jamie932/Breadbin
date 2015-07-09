<?php 
    require("common.php"); 
	require("vendor/ImageResize.class.php");

	$data = array();

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
            $data['success'] = true;
            $data['url'] = 'img/avatars/' . $_SESSION['user']['id'] . '/' . $newfile;
        } else {
            $data['success'] = false;
            $data['error'] = 'A problem occured resizing the avatar.';
        }
        
    } else {
        $data['success'] = false;
        $data['error'] = 'Nothing found to upload.';  
    }

    echo json_encode($data);
?> 