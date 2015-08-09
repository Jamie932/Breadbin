<?php 
    require("php/common.php");
    require("php/checkLogin.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search | Breadbin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="css/common.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href="css/search.css" rel="stylesheet" type="text/css">
    <link href="css/vendor/normalize.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="js/vendor/jquery-1.11.2.min.js"></script>
    <script src="js/vendor/jquery.cookie.js"></script>
    <script src="js/pages/main.js"></script>
    <script src="js/postFunctions.js"></script>
    <script src="js/errorHandler.js"></script>
    <script src="js/vendor/progressbar.min.js"></script>
	<script>
		$(document).ready(function(){
			$('.fa-angle-double-down').click(function(){
				$(this).addClass('fa-rotate-negative-90');
			})
			
			$(document).on('click','.fa-rotate-negative-90', function() {
				$(this).removeClass('fa-rotate-negative-90');
			})
		})
	</script>
</head> 
<body>
    <noscript>
      <META HTTP-EQUIV="Refresh" CONTENT="0;URL=error.php">
    </noscript>    
		
    <?php require('php/template/navbar.php');?>
    <?php require('php/template/popup.php');?>
        
    <div id="break"></div>
    
    <div id="center">  
        <div id="content">
            <ul id="images">
				<?php require('php/fetchSearch.php');?>
				
						
				<div id="usersBox">
					<?php echo isset($colour) ? '<div class="boxTitle" style="background-color: '. $colour . '"><b>0</b> Posts Found' : '<div class="boxTitle"><b>0</b> Posts Found'; ?>
					<div class="expand"><i class="fa fa-angle-double-down"></i></div></div>
				</div>
            </ul>
        </div>
        
        <div id="sidebar">
            <div id="support" class="sideBox">
				About Support etc etc
			</div>
        </div>        
    </div>
</body>
</html>