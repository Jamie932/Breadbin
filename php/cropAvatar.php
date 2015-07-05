<?php
session_start();

$imgUrl = $_POST['imgUrl'];
// original sizes
$imgInitW = $_POST['imgInitW'];
$imgInitH = $_POST['imgInitH'];
// resized sizes
$imgW = $_POST['imgW'];
$imgH = $_POST['imgH'];
// offsets
$imgY1 = $_POST['imgY1'];
$imgX1 = $_POST['imgX1'];
// crop box
$cropW = $_POST['cropW'];
$cropH = $_POST['cropH'];
// rotation angle
$angle = $_POST['rotation'];

$jpeg_quality = 100;

$output_filename = '../img/avatars/' . $_SESSION['user']['id'] . '/avatar';

$what = getimagesize($imgUrl);

switch(strtolower($what['mime']))
{
    case 'image/png':
		$source_image = imagecreatefrompng($imgUrl);
		$type = '.png';
        break;
    case 'image/jpeg':
		$source_image = imagecreatefromjpeg($imgUrl);
		error_log("jpg");
		$type = '.jpeg';
        break;
    case 'image/gif':
		$source_image = imagecreatefromgif($imgUrl);
		$type = '.gif';
        break;
    default: die('image type not supported');
}

if(file_exists($output_filename . '.jpg')) { 
    unlink($output_filename . '.jpg');
}

//Check write Access to Directory

if(!is_writable(dirname($output_filename))){
	$response = Array(
	    "status" => 'error',
	    "message" => 'Can`t write cropped File'
    );	
}else{
    $resizedImage = imagecreatetruecolor($imgW, $imgH);
    imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
    
    imagejpeg($resizedImage, $output_filename.'.jpg', 80);
    
	$response = Array(
	    "status" => 'success',
	    "url" => 'img/avatars/' . $_SESSION['user']['id'] . '/avatar.jpg?r=' . rand()
    );
}
print json_encode($response);