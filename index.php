<?php
session_start();

   require("php/common.php");

    if(!empty($_SESSION['user'])) 
    {
        header("Location: main.php");
        die("Redirecting to main.php"); 
    } 
?>
<html>
<head>
    <title>Bread Bin</title>
    <link href="css/index.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/jquery.cookie.js"></script>
    <script src="js/login.js"></script>
    <script src="js/top.js"></script>
    <script>
        $(document).ready(function(){
           $(".registerBtn").click(function(){
               $(".login").fadeOut('normal', function(){
                $(".register").fadeIn('normal');
				
				$('.logUserName').removeClass('error');
				$('.logUserPass').removeClass('error');
				$('small').remove();
           });
		});
       });
    </script>
    <script>
        $(document).ready(function(){
           $(".loginBtn").click(function(){
               $(".register").fadeOut('normal', function(){
                $(".login").fadeIn('normal');
				
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
    <div id="mid">
        
        <div class="login">
            <h2>Login</h2>
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
					
					<div class="dockBottom">
						<p style="font-size: 10px; margin-bottom: -18px; margin-top: 18px;">No account?<p>
						<a class="registerBtn">Register</a>
					</div>
				</form>
			</div>
        </div>
        
        <div class="register">
            <h2>Register</h2>
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
					</div><br>
					<div class="clearFix"></div>
					
	
					<input type="submit" class="btn btn-info" value="Submit" id="submit"/>
					
					<div class="dockBottom">
						<p style="font-size: 10px; margin-bottom: -18px; margin-top: 18px;">Already have an account?<p>
						<a class="loginBtn">Login</a>
					</div> 
				</form>
			</div>
        </div>
    </div>
	
	<script src="js/formRegister.js"></script>
	<script src="js/formLogin.js"></script>
</body>
</html>