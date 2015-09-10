<?php 
    require("php/common.php");
    require("php/checkLogin.php");

    $postsPerPage = 10;

    $query = 'SELECT COUNT(*) FROM posts'; 
    $stmt = $db->prepare($query); 
    $result = $stmt->execute(); 
    $numPosts = $stmt->fetchColumn();
    $numPages = ceil($numPosts / $postsPerPage);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Breadbin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="css/common.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href="css/vendor/magic.css" rel="stylesheet" type="text/css">
    <link href="css/vendor/lazyYT.css" rel="stylesheet" type="text/css">
    <link href="css/vendor/normalize.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="js/vendor/jquery-1.11.2.min.js"></script>
    <script src="js/vendor/jquery.cookie.js"></script>
    <script src="js/vendor/jquery.hoverIntent.js"></script>
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
        
    <script>
        var instruction = 1;
        function add_fieldsInstruc() {
            instruction++;
            
            var container = document.createElement("div");
            container.style.width = "100%";
            container.style.height = "100px";
            container.innerHTML = '<div class="leftInstruc"><p class="number">' + instruction + '</p></div><div class="rightInstruc"><textarea name="recipeInstructions" class="recipeInstructions" id="recipeInstructions" maxlength="260" placeholder="Recipe Instructions..." autocomplete="off"></textarea></div>';
            document.getElementById("instructionBody").appendChild(container);   
            
            /*document.getElementById('instructionBody').innerHTML += '<div id="eachInstruc"><div class="leftInstruc"><p class="number">' + instruction + '</p></div><div class="rightInstruc"><textarea name="recipeInstructions" class="recipeInstructions" id="recipeInstructions" maxlength="220" placeholder="Recipe Instructions..."></textarea></div></div>';*/
        }
        
        function add_fields() {
            var container = document.createElement("div");
            container.style.width = "210px";
            container.style.display = "inline";
            container.innerHTML = '<input type="text" name="recipeIngredients" id="recipeIngredients" placeholder="Recipe Ingredient" class="recipeIngredients" autocomplete="off" />';
            document.getElementById("ingredientBody").appendChild(container);   
            
            /*document.getElementById('ingredientBody').innerHTML += '<input type="text" name="recipeIngredients" id="recipeIngredients" placeholder="Recipe Ingredient" class="recipeIngredients" style="margin  " />';*/
        }
    </script>
    
    
    <?php require('php/template/gridPopUp.php');?>

    <div id="blackOverlay"></div>   
    
    <div id="center">  
        <div id="content">
        	<?php require('php/fetchPosts.php'); ?>
        </div>
        
        <div id="sidebar">
            <div id="uploadBox" class="sideBox">
                <form action="php/post.php" method="POST" id="postForm" enctype="multipart/form-data">
                    <div class="textarea">
                        <textarea name="TextUpload" class="postText" id="uploadText" maxlength="150" placeholder="Make a slice..." rows="1"></textarea>
                    </div>
                    
                    <div class="uploadRest">
                        <input type="submit" value="Submit" id="submitPost" class="buttonstyle">
                         
                        <div id="imageIcon"><a href="#" onclick="getFile();"><i class="fa fa-camera"></i></a></div>
                        <div style='height: 0px;width:0px; overflow:hidden;'><input id="upfile" type="file" value="upfile" accept="image/*"/></div>
                        <div id="uploadname"></div>
                    </div>
                </form>
                
                <div id="gridClick">
                    <div class="gridBoxes 2">
                        <i class="fa fa-video-camera" style="font-size: 2.3em;"></i>
                    </div>
                    <div class="gridBoxes 1">
                        <i class="fa fa-cutlery" style="font-size: 2.3em;"></i>
                    </div>
                </div>
				
                <div class="clearFix"></div>
     		</div> 
			
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
		
	<script>
		var loading = false;
		var groupNumber = 1;

		$(window).scroll(function() {
			if ($(window).scrollTop() + $(window).height() == $(document).height()) {

				if (loading == false && groupNumber <= <?php echo $numPages ?>) {
					loading = true;

					$.post('php/fetchPosts.php', {'groupNumber' : groupNumber}, function(data) {
						$("#content").append(data);
						loading = false;
						groupNumber++;
						$('.js-lazyYT').lazyYT(); 
					});
				}
			}
		});
	</script>  
</body>
</html>