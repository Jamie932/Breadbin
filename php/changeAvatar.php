<?php 
    require("common.php"); 
	
    if(isset($_FILES["file"])) {
        $updirectory = '../img/avatars/' . $_SESSION['user']['id'] . '/';
        $filename = strtolower($_FILES['file']['name']);
        $extension = substr($filename, strrpos($filename, '.'));
        $newfile = "avatar".$extension;
        
        if (!file_exists('../img/avatars/' . $_SESSION['user']['id'])) {
            mkdir('../img/avatars/' . $_SESSION['user']['id'], 0777, true);
        } else {
            if(file_exists($updirectory . $newfile)) { 
                unlink($updirectory . $newfile);
            }
        }
        
        if ($extension == ".png") {
            $image = imagecreatefrompng($updirectory.$newfile);
            $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
            imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
            imagealphablending($bg, TRUE);
            imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
            imagedestroy($image);
            $quality = 50; // 0 = worst / smaller file, 100 = better / bigger file 
            imagejpeg($bg, $updirectory . $rand . ".jpg", $quality);
            imagedestroy($bg);
            $converted = true;
            $convertedfile = $updirectory . $rand . ".jpg";
        }
        
        if($converted && move_uploaded_file($_FILES['file']['tmp_name'], $convertedfile ) || (!$converted && move_uploaded_file($_FILES['file']['tmp_name'], $updirectory.$newfile ))) {   
            $query = "UPDATE users SET avatar=:avatar WHERE id=:id"; 
            $query_params = array(':id' => $_SESSION['user']['id'], ':avatar' => $converted ? $convertedfile : $updirectory.$newfile); 
            
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
             die('Success: File Uploaded.');

        } else {
            die("Error: Couldn't upload the file.");
        }
        
    } else {
        die('Error: Nothing found to upload.');   
    }
?> 