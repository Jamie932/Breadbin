<?php
	require("php/common.php");
	require("php/checkLogin.php");

	if (empty($_GET)) {
		if ($_SESSION['user']['id']) {
			header('Location: main.php');
			die();
		}
	} else {
		$query = "SELECT * FROM posts WHERE id=:id";
		$query_params = array(':id' => $_GET['p']); 

		$stmt = $db->prepare($query); 
		$result = $stmt->execute($query_params); 
		$row = $stmt->fetch();  

		if (!$row) {
			header('Location: main.php');
			die();
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post <?php echo htmlspecialchars($_GET['p']) ?> | Breadbin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="css/common.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href="css/vendor/lazyYT.css" rel="stylesheet" type="text/css">
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
    <script type="text/javascript" src="js/vendor/lazyYT.js"></script>
    <script>		 
		$( document ).ready(function() {
			$('.js-lazyYT').lazyYT(); 
		});
    </script>
</head>
    
<body>
    <noscript>
      <META HTTP-EQUIV="Refresh" CONTENT="0;URL=error.php">
    </noscript>    
    
    <?php require('php/template/navbar.php');?>
    <?php require('php/template/popup.php');?>
    
    <div id="center">
        <div id="content">
        	<?php require('php/fetchPosts.php'); ?>
        </div>
		
        <div id="sidebar">
			<?php require('php/recommendToaster.php'); ?>
            
            <div id="supportBox" class="sideBox">
				<ul id="credits">
					<li>&#169; 2015 Breadbin</li>
					<li><a href="http://google.co.uk" target="_blank">About</a></li>
					<li><a href="http://google.co.uk" target="_blank">Help</a></li>
					<li><a href="http://google.co.uk" target="_blank">Privacy</a></li>
					<li><a href="http://google.co.uk" target="_blank">Terms</a></li>
				</ul>
			</div>
            
        </div>        
    </div>
</body>
</html>