<?php
    require("php/common.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Email Verification | Breadbin </title>
    <link href="css/common.css" rel="stylesheet" type="text/css">
    <link href="css/index.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/vendor/normalize.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="js/vendor/jquery-1.11.2.min.js"></script>
    <script src="js/vendor/jquery.cookie.js"></script>
    <script src="js/pages/index.js"></script>
    <script src="js/errorHandler.js"></script>
</head>
<body>
    <noscript>
      <META HTTP-EQUIV="Refresh" CONTENT="0;URL=error.php">
    </noscript>  
	
	<div id="errorBar">
		<div id="errorText"></div>
		<div id="errorClose"><i class="fa fa-times" style="line-height: 35px"></i></div>
	</div>	
	
    <div id="mainLogo">
        <img src="/img/logo.png">   
    </div>
        
    <div id="mid">
		<div class="validated active">
			<div id="header">Email Verification</div>

			<div class="textContainer">
                <?php
                    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
                        $query = "SELECT * FROM uniquelogs WHERE hash = :hash";
                        $query_params = array(':hash' => $_GET['hash']); 
                        
                        $stmt = $db->prepare($query); 
                        $result = $stmt->execute($query_params); 
                        $row = $stmt->fetch(); 

                        if ($row) {
                            $userid = $row['userid'];

                            $query = "SELECT * FROM users WHERE id = :id";
                            $query_params = array(':id' => $userid); 
                            
                            $stmt = $db->prepare($query); 
                            $result = $stmt->execute($query_params); 
                            $row = $stmt->fetch(); 
    
                            if ($row) {
                                $query = "UPDATE users SET active=1 WHERE id = :id";
                                $query_params = array(':id' => $userid); 
                                    
                                $stmt = $db->prepare($query); 
                                $result = $stmt->execute($query_params);  

                                echo "<p>You've successfully verified your email and are ready to start your Breadbin experience!</p><p>Please click <a href='index.php' style='text-decoration: none;'>here</a> to login.";
                            } else {
                                echo "<p>Your email could not be verified - please tell an administrator.</p>";
                            }
                        } else {
                            echo "<p>This URL is either invalid or you have already activated your account.</p>";   
                        }
                    } else {
                         echo "<p>Invalid URL - please use the link within your email.</p>";
                    }
                ?>
			</div>
		</div>
 	</div>
		
</body>
</html>