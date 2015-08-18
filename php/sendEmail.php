<?php
	header("Content-Type: application/json", true);
    require("common.php");
	require('vendor/class.phpmailer.php');
	
    $hash = md5(uniqid(rand(), true));

    $query = "SELECT * FROM users WHERE username = :username";
    $query_params = array(':username' => $_POST['username']); 

    $stmt = $db->prepare($query); 
    $result = $stmt->execute($query_params); 
    $row = $stmt->fetch(); 

    $userid = $row['id'];
    $username = $row['username'];

    $query = "INSERT INTO uniquelogs(userid, hash) VALUES(:userid, :hash) ON DUPLICATE KEY UPDATE hash = :hash;"; 
    $query_params = array(':userid' => $userid, ':hash' => $hash); 

    $stmt = $db->prepare($query); 
    $result = $stmt->execute($query_params); 

	$mail = new PHPMailer;
	$mail->AddReplyTo("noreply@breadbin.com","Breadbin");
	$mail->SetFrom('noreply@breadbin.com', 'Breadbin');
	$mail->AddAddress($_POST['email'], $_POST['username']);
	$mail->Subject = "Breadbin | Email Verification";
	$mail->isHTML(true); 

    $message = '<img src="http://yourmums.science/img/logo.png" style="display:block; margin:auto;"><br>
    Thanks for signing up!<br>
    Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.<br><br>

    ------------------------<br>
    Username: '.$username.'<br>
    Password: '.$_POST['password'].'<br>
    ------------------------<br><br>

    Please click this link to activate your account:<br>
    http://yourmums.science/verify.php?email='.$row['email'].'&hash='.$hash.'<br>';

	$mail->MsgHTML($message);

	if(!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Message sent!";
	}
?>