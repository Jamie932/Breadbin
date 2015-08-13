<!DOCTYPE html>
<html>
<head>
    <title>Breadbin</title>
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
        <img src="img/logo.png">   
    </div>
        
    <div id="mid">
		<div class="login active">
			<div id="header">Log in</div>
			
			<div class="loginForm">
				<form id="logForm" action="php/login.php" method="POST"> 
					<input type="text" name="log_username" placeholder="Username" class="logUserName textField" required/> 
					<input type="password" name="log_password" placeholder="Password" class="logUserPass textField" required/> 
						
					<input type="submit" class="btn btn-info" value="Submit" id="submit"/>					
				</form>
				<div class="forgotPass"><a>Forgotten your password?</a></div>
			</div>
		</div>
		
		<div class="register">
			<div id="header">Register</div>
			
			<div class="registerForm">
				<form id="regForm" action="php/register.php" method="POST" autocomplete="off">
					<input type="text" name="reg_username" placeholder="Username" class="regUserName textField" required/>
					<input type="email" name="reg_email" placeholder="Email" class="regUserEmail textField" required/>
					<input type="password" name="reg_password" placeholder="Password" class="regUserPass textField" required/>
					<input type="password" name="reg_confirmPassword" placeholder="Confirm Password" class="regUserConfirm textField" required/>
				
					<input type="submit" class="btn btn-info" value="Submit" id="submit"/>	
					<div style="font-size:0.65em; color: #7E7E7E;">
						<p>By pressing submit you agree to our terms of service.</p> 			
					</div>				
				</form>
			</div>
		</div>
    
		<div class="verify">
			<div id="header">Almost there!</div>
			
			<div class="textContainer">
                <p>To finish your registration, please check validate your email.</p> 
                <p>Once you've clicked on the link in the email, you will be able to access your account.</p>
                <br>
                <p>Can't find the email? Please try to ... </p>
			</div>
		</div>
		
		<div class="terms">
			<div id="header">Terms of Service</div>
			
			<div class="textContainer">
                <p>Blah blah blah blah.</p> 
                <p>Once you've clicked on the link in the email, you will be able to access your account.</p>
                <br>
                <p>Can't find the email? Please try to ... </p>
			</div>
		</div>
		
		<div class="privacy">
			<div id="header">Privacy Policy</div>
			
			<div class="textContainer">
                <p>Blah blah blah blah.</p> 
                <p>Once you've clicked on the link in the email, you will be able to access your account.</p>
                <br>
                <p>Can't find the email? Please try to ... </p>
			</div>
		</div>
		
		<div class="about">
			<div id="header">About</div>
			
			<div class="textContainer">
                <p>Blah blah blah blah.</p> 
                <p>Once you've clicked on the link in the email, you will be able to access your account.</p>
                <br>
                <p>Can't find the email? Please try to ... </p>
			</div>
		</div>
    
        <div class="dockBottom">
            <ul>
                <li><a class="termsBtn">Terms of Service</a></li>
                <li><a class="privacyBtn">Privacy Policy</a></li>
                <li><a class="aboutBtn">About</a></li>
            </ul>
        </div>
	</div>
	
	<div class="dockBelow">
		Don't have an account? <a class="registerBtn">Sign up</a>
	</div>	
</body>
</html>