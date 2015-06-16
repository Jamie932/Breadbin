<?php
    require("php/common.php");
    require("php/checkLogin.php");
?>
<html>
<head>
    <title>Breadbin</title>
    <link href="css/index.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/jquery.cookie.js"></script>
    <script>
        $(document).ready(function(){
           $(".registerBtn").click(function(){
               $(".login").fadeOut('normal', function(){
                $(".register").fadeIn('normal');
				$("#mid").addClass('tall');
				
				$('.logUserName').removeClass('error');
				$('.logUserPass').removeClass('error');
				$('small').remove();
           });
		});
       });
        
        $(document).ready(function(){
           $(".loginBtn").click(function(){
               $(".register").fadeOut('normal', function(){
                $(".login").fadeIn('normal');
				$("#mid").removeClass('tall');
				
				$('.regUserName').removeClass('error');
				$('.regUserEmail').removeClass('error');
				$('.regUserPass').removeClass('error');
				$('.regUserConfirm').removeClass('error');
				$('small').remove();
           });
       });
    });
    </script>
</head>
<body>
    <noscript>
      <META HTTP-EQUIV="Refresh" CONTENT="0;URL=error.php">
    </noscript>        
    
    <div id="mid">
		<div class="login">
			<div id="header">
				<h2>Login</h2>
				<div class="dockHeader">
					No account? <a class="registerBtn">Register</a>
				</div>	
			</div>
			
			<hr></hr>
			
			<div class="loginForm">
				<form id="logForm" action="php/login.php" method="POST"> 
					<div id="logUserName-group">
						<input type="text" name="log_username" placeholder="Username" class="logUserName"/>  
					</div>
					<div class="clearFix"></div>
					
					<div id="logUserPass-group">
						<input type="password" name="log_password" placeholder="Password" class="logUserPass"/> 
					</div>
					<div class="clearFix"></div>
					
					<input type="submit" class="btn btn-info" value="Submit" id="submit"/>					
				</form>
			</div>
			<div class="dockBottom">
				<ul>
					<li>Terms of Service</li>
					<li>Privacy Policy</li>
				</ul>
			</div>
		</div>
		
		<div class="register">
			<div id="header">
				<h2>Register</h2>
				<div class="dockHeader">
					Already have an account? <a class="loginBtn">Login</a>
				</div>	
			</div>
			
			<hr></hr>
			
			<div class="registerForm">
				<form id="regForm" action="php/register.php" method="POST"> 
					<div id="regUserName-group">
						<input type="text" name="reg_username" placeholder="Username" class="regUserName"/>  
					</div>
					<div class="clearFix"></div>
					
					<div id="regUserEmail-group">
						<input type="text" name="reg_email" placeholder="Email" class="regUserEmail"/> 
					</div>
					<div class="clearFix"></div>
					
					<div id="regUserPass-group">
						<input type="password" name="reg_password" placeholder="Password" class="regUserPass"/> 
					</div>
					<div class="clearFix"></div>
					
					<div id="regUserConfirm-group">
						<input type="password" name="reg_confirmPassword" placeholder="Confirm Password" class="regUserConfirm"/>
					</div>
					<div class="clearFix"></div>
					
	
					<input type="submit" class="btn btn-info" value="Submit" id="submit"/>					
				</form>
				
				<div class="dockBottom">
					<ul>
						<li>Terms of Service</li>
						<li>Privacy Policy</li>
					</ul>
				</div>	
			</div>
		</div>
    
		<div class="verify">
			<div id="header">
				<h2>Thank you!</h2>
			</div>
			
			<hr></hr>
			
			<div style="font-size:0.9em;">
                <p>To finish your registeration, please check validate your email.</p> 
                <p>Once you've clicked on the link in the email, you will be able to access your account.</p>
                <br>
                <p>Can't find the email? Please try to ... </p>
			</div>
    
			<div class="dockBottom">
				<ul>
					<li>Terms of Service</li>
					<li>Privacy Policy</li>
				</ul>
			</div>
		</div>
	</div>
	
	<script src="js/formRegister.js"></script>
	<script src="js/formLogin.js"></script>
</body>
</html>