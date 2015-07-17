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
</head> 
<body>
    <noscript>
      <META HTTP-EQUIV="Refresh" CONTENT="0;URL=error.php">
    </noscript>    
    
    <?php require('php/template/navbar.php');?>
    <?php require('php/template/popup.php');?>
        
    <div id="break"></div>
        
    <script>
        var instruction = 1;
        function add_fieldsInstruc() {
            instruction++;
            document.getElementById('instructionBody').innerHTML += '<div id="eachInstruc"><div class="leftInstruc"><p class="number">' + instruction +'</p></div><div class="rightInstruc"><textarea name="TextUpload" class="recipeInstructions" id="recipeInstructions" maxlength="220" placeholder="Recipe Instructions..."></textarea></div></div>';
        }
    </script>
        
    <div id="recipeBox">
            <div class="recipeContent"> 
                <div class="recipeHeader">
                    <h1>Post your recipe</h1>
                </div>

                <hr></hr>
                
                <div id="recipeForm">
                    <form action="php/postRecipe.php" method="POST" id="postRecipeForm" enctype="multipart/form-data">
                        
                        <div id="sectionHeader">
                            <h3>Recipe Title</h3>
                        </div>
                        <div id="titleBody">
                            <center><input type="text" id="recipeTitle" name="recipeTitle" placeholder="Recipe Title" class="recipeTitle" required/></center>
                        </div>
                            
                            
                        <div id="sectionHeader">
                            <div class="leftHeader">
                                <h3>Ingredients</h3>
                            </div>
                            <div class="rightHeader">
                            <input type="button" id="more_fields" onclick="add_fields();" value="New Ingredient" />
                            </div>
                        </div>
                        <div id="ingredientBody">
                            <input type="text" name="recipeIngredients" id="recipeIngredients" placeholder="Recipe Ingredient" class="recipeIngredients" required/>
                            <input type="text" name="recipeIngredients" id="recipeIngredients" placeholder="Recipe Ingredient" class="recipeIngredients" style="margin-left: 6px;" required/>
                        </div>
                        
                        <div id="sectionHeader">
                            <div class="leftHeader">
                                <h3>Instructions</h3>
                            </div>
                            <div class="rightHeader">
                            <input type="button" id="more_fields" onclick="add_fieldsInstruc();" value="New Instruction" />
                            </div>
                        </div>
                        <div id="instructionBody">
                            <div id="eachInstruc">
                            <div class="leftInstruc">
                                <p class="number">1</p>
                            </div>
                            <div class="rightInstruc">
                            <textarea name="recipeInstructions" class="recipeInstructions" id="recipeInstructions" maxlength="220" placeholder="Recipe Instructions..."></textarea>
                            </div>
                            </div>
                        </div>
                        
                            <br>
                            <center><input type="submit" value="Submit" id="submitRecipe" class="buttonstyle">
                            <input type="button" id="cancel" class="buttonstyle" value="Cancel" /></center>
                    </form>
                </div>
            </div>
        </div>

    <div id="blackOverlay"></div>   
    
    <div id="center">
        <script>
            var loading = false;
            var groupNumber = 1;
            
            $(window).scroll(function() {
                if ($(window).scrollTop() + $(window).height() == $(document).height()) {
                    
                    
                    if (loading == false && groupNumber <= <?php echo $numPages ?>) {
                        loading = true;
                        
                        $.post('php/fetchPosts.php', {'groupNumber' : groupNumber}, function(data) {
                            $("#images").append(data);
                            loading = false;
                            groupNumber++;
                        });
                    }
                }
            });
        </script>    
        
        <div id="content">
            <ul id="images">
                <?php require('php/fetchPosts.php');?>
            </ul>
        </div>
        
        <div id="sidebar">
            <div id="upload" class="sideBox">
                <form action="php/post.php" method="POST" id="postForm" enctype="multipart/form-data">
                    <div class="textarea">
                        <textarea name="TextUpload" class="postText" id="uploadText" maxlength="150" placeholder="Make a slice..."></textarea>
                    </div>
                    
                    <div class="uploadRest">
                        <input type="submit" value="Submit" id="submitPost" class="buttonstyle">
                         
                        <div id="imageIcon"><a href="#" onclick="getFile();"><i class="fa fa-camera"></i></a></div>
                        <div style='height: 0px;width:0px; overflow:hidden;'><input id="upfile" type="file" value="upfile" accept="image/*"/></div>
                        <div id="uploadname"></div>
                    </div>
                </form>
                
                <div id="blackout">
                    <p>blackout</p>
                </div>
				
                <div class="clearFix"></div>
				<?php require('php/recommendToaster.php');  ?>
     		</div> 
            
            <div id="support" class="sideBox">
				About Support etc etc
			</div>
            
        </div>        
    </div>
</body>
</html>