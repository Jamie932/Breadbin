<?php
	header("Content-Type: application/json", true);
    require("common.php");
	
	function checkLength($s, $min, $max) {
		if (strlen($s) > $max) { return 2; }
		elseif (strlen($s) < $min) { return 1; }
		else { return 0; }
	};

	$errors = array();
	$data = array();
	
	// Checking for errors.
    if (checkLength($_POST['firstname'], 1,20) > 0) {
        $errors['firstname'] = '1-20 characters required.';
	} if (checkLength($_POST['lastname'], 1,20) > 0) {
        $errors['lastname'] = '1-20 characters required.';
	} 
	
    if (!empty($_POST['email'])) {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'The specified email is not valid.';
	} else {
       $query = "SELECT 1 FROM users WHERE email = :email";
       $query_params = array(':email' => $_POST['email']); 
        try { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage());} 
		
        $row = $stmt->fetch(); 
		if($row){ $errors['email'] = 'This email address is already registered.'; }
	}
    }
	
    if (!empty($errors)) { // Were any errors found? If so do not continue and feed back the errors to HTML.
        $data['success'] = false;
        $data['errors']  = $errors;
		
    } else { //If not then add the user wooo

        $query="UPDATE users SET firstname = '$_POST['firstname']', lastname = '$_POST['lastname']', email = '$_POST['email']', colour = '$_POST['colour']' WHERE id = '$_SESSION['user']';";
        $query=mysql_query($sql1);
        ); 
        if($result1){
            header("location:main.php");
        }
        mysql_close();
    }

    echo json_encode($data);
?>