<?php
	header("Content-Type: application/json", true);
    require("common.php");
	
    $hash = md5(uniqid(rand(), true));

    $query = "SELECT * FROM users WHERE username = :username";
    $query_params = array(':username' => $_POST['username']); 
    try { 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
    } 
    catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 

    $row = $stmt->fetch(); 
    $userid = $row['id'];
    $username = $row['username'];

    $query = "INSERT INTO uniquelogs(userid, hash) VALUES(:userid, :hash) ON DUPLICATE KEY UPDATE hash = :hash;"; 
    $query_params = array(':userid' => $userid, ':hash' => $hash); 

    try{ 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
    } 
    catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 

    $to      = $_POST['email'];
    $subject = 'Breadbin | Email Verification'; 
    $message = '

    Thanks for signing up!
    Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.

    ------------------------
    Username: '.$username.'
    Password: '.$_POST['password'].'
    ------------------------

    Please click this link to activate your account:
    http://yourmums.science/verifyEmail.php?email='.$row['email'].'&hash='.$hash.'

    ';

    $headers = 'From:noreply@breadbin.com' . "\r\n"; // Set from headers
    mail($to, $subject, $message, $headers); // Send our email
?>