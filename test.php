<html>
<head>
    <link href="css/common.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <script src="js/vendor/jquery-1.11.2.min.js"></script>
    <script src="js/pages/main.js"></script>
</head>
    <body>
    
     <div id="navbar">
         
	<div class="left">
		<a href="main.php" class="navLinks">Bread Bin</a> 
	</div>
         
    <div id="loader">
		
    </div>
	
	<div class="right">
		<ul class="nav">
            <li class="nav">
                <a class="navLinks" href="discover.php">Discover</a>
            </li>
                <li class="nav">

               <a class="navLinks" href="../profile.php?id=' . $_SESSION['user']['id'] . '">Bill</a>
               <div class="arrow-up"></div>
                <ul>
                    <li><a class="navLinks" href="../settings.php">Settings</a></li>
                    <li><a class="navLinks" href="#" onClick="logout(); return false;">Logout</a></li>
                </ul>
			</li>
            <!--<li class="nav"><a class="navLinks" href="#" onClick="logout(); return false;" >Logout</a></li>-->
		</ul>
	</div>
</div>

<div id="errorBar"></div>

    <!--<div style="margin-top: 100px;">
        <div id="contentPost" class="post-' . $row['id'] . '">
        <div class="contentPostRecipe">
            <h3 class="recipeTitle">Post Title</h3>
            <h4 class="ingredientsTitle">Ingredients</h4>
            <div id="ingredientLists">
                <div class="leftIngredients">
                    <p class="ingred">Bread - 150g</p>
                    <p class="ingred">Bread - 150g</p>
                    <p class="ingred">Bread - 150g</p>
                </div>
                <div class="rightIngredients">
                    <p class="ingred">Bread - 150g</p>
                    <p class="ingred">Bread - 150g</p>
                    <p class="ingred">Bread - 150g</p>
                 </div>
            </div>
            <div id="instructions">
                <h4 class="ingredientsTitle">Instructions</h4>
                <p>10 mins in the fridge then cook it whilst doing some yoga :)</p>
            </div>
        </div>
          
    </div>-->
        
    <script>
        var instruction = 1;
        function add_fieldsInstruc() {
            instruction++;
            document.getElementById('instructionBody').innerHTML += '<div id="eachInstruc"><div class="leftInstruc"><p class="number">' + instruction +'</p></div><div class="rightInstruc"><textarea name="TextUpload" class="recipeInstructions" id="recipeInstructions" maxlength="220" placeholder="Recipe Instructions..."></textarea></div></div>';
        }
    </script>
        
    <div id="recipeBox" style="display: inline;">
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
                            <input type="text" name="recipeIngredients" id="recipeIngredients" placeholder="Recipe Ingredient" class="recipeIngredients"style="margin-left: 6px;" required/>
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
                            <textarea name="TextUpload" class="recipeInstructions" id="recipeInstructions" maxlength="220" placeholder="Recipe Instructions..."></textarea>
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
        
</body>
</html>