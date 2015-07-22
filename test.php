<html>
<head>
    <link href="css/common.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <script src="js/vendor/jquery-1.11.2.min.js"></script>
    <script src="js/pages/main.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
    <body>
    
     <div id="navbar">
         
	<div class="left">
		<a href="main.php" class="navLinks">Bread Bin</a> 
	</div>
         
    <div id="loader">
		
    </div>

    <div id="gridBox">
        <div class="gridBoxes 1"></div>
		<div class="gridBoxes 2"></div>
		<div class="gridBoxes 3"></div>
		<div class="gridBoxes 4"></div>
		<div class="gridBoxes 5"></div>
		<div class="gridBoxes 6"></div>
		<div class="gridBoxes 7"></div>
		<div class="gridBoxes 8"></div>
		<div class="gridBoxes 9"></div>
    </div>
    <!--
    <div id="post" style="margin-top: 100px;" >
        <div id="contentPost" class="post-' . $row['id'] . '" >
            <div id="heart" style="z-index: 1; margin-bottom: -20px;"><i class="fa fa-trash-o" style="font-size: 2em;"></i></div>
            <div class="contentPostText" style="color: black;">
                <div class="recTitle">
                    <h3 class="recTit">Title</h3>
                </div>
                <div class="timeServe">
                    <p class="times" style="margin-right: 50px;"><b>Prep time:</b> 1hr 10mins</p>
                    <p class="times" style="margin-right: 50px;"><b>Cooking time:</b> 4hrs 45mins</p>
                    <p class="times" ><b>Serves:</b> 1-4 people</p>
                </div>
                <div class="ingredientDis">
                    <p class="ingredList">Mayo - 100ml</p>
                    <p class="ingredList">Mayo</p>
                    <p class="ingredList">Mayo</p>
                    <p class="ingredList">Mayo</p>
                    <p class="ingredList">Mayo</p>
                    <p class="ingredList">Mayo</p>
                    <p class="ingredList">Mayo</p>
                    <p class="ingredList">Mayo</p>
                </div>
                <div class="instructionList">
                    <h6>Instructions</h6>
                    <p class="instructionList"><b class="instructionNo">1.</b>jjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsdlkgjjjsd</p>
                </div>
            </div>
            
        </div>
          
    </div>
     
    
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
        </div>-->
        
</body>
</html>