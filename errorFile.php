<?php 
    require("php/common.php");
    require("php/checkLogin.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Breadbin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="css/common.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/error.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="js/vendor/jquery-1.11.2.min.js"></script>
    <script src="js/vendor/jquery.cookie.js"></script>
</head>
<body>
    <noscript>
      <META HTTP-EQUIV="Refresh" CONTENT="0;URL=error.php">
    </noscript>    
    
   <?php require('php/template/navbar.php');?>
        
<?php
$status = $_SERVER['REDIRECT_STATUS'];
$codes = array(
        403 => array('403 Forbidden', 'You do not have the correct permissions to view this page.'),
        404 => array('PAGE NOT FOUND', 'YOU LOOK LOST'),
        405 => array('405 Method Not Allowed', 'The method specified in the Request-Line is not allowed for the specified resource.'),
        408 => array('408 Request Timeout', 'Your browser failed to sent a request in the time allowed by the server.'),
        500 => array('500 Internal Server Error', 'The request was unsuccessful due to an unexpected condition encountered by the server.'),
        502 => array('502 Bad Gateway', 'The server received an invalid response from the upstream server while trying to fulfill the request.'),
        504 => array('504 Gateway Timeout', 'The upstream server failed to send a request in the time allowed by the server.')
        );

if ($status = 200) {
    if (isset($_GET['error'])) {
        $title = $codes[$GET['error']][0];
        $message = $codes[$GET['error']][1];
    
} else {
    $title = $codes[$status][0];
    $message = $codes[$status][1];
    if ($title == false || strlen($status) != 3) {
        $message = 'Please supply a valid status code.';
    }
}

?>

<div id="content">
<?php
echo '<p style="font-size: 20px; margin-bottom: 30px;">' . $message . '</p>' . 
     '<p><h1 style="margin-bottom: 50px;">' . $title . '</h1></p>'; 
     
?> 
    <a class="home" href="/main.php">Go Home</a>
</div>
</body>