<div id="gridBox">
        <div class="innerGrid">
        <div class="popupTitle" style="margin: -1px;">
                    <div id="leftTitle">Your post grid</div>
                    <div id="rightTitleRec"><i class="fa fa-times"></i></div>
            </div>
            <div class="gridBoxes 1">
                <i class="fa fa-cutlery" style="font-size: 8.2em; text-align: center; margin-left: 9px;"></i>
            </div>
            <div class="gridBoxes 2">
            <i class="fa fa-video-camera" style="font-size: 8.2em; text-align: center; margin-left: 9px;"></i>
            <center>Video</center>
          </div>  
		  <div class="gridBoxes 3"></div>
		  <div class="gridBoxes 4"></div>
		  <div class="gridBoxes 5"></div>
		  <div class="gridBoxes 6"></div>
		  <div class="gridBoxes 7"></div>
		  <div class="gridBoxes 8"></div>
		  <div class="gridBoxes 9"></div>
        </div>
    
        <div class="innerVideo" style="display: none;">
            <div class="popupTitle" style="margin: -1px;">
                    <div id="leftTitle">Post a video</div>
                    <div id="rightTitleBack" class="vidBack"><i class="fa fa-arrow-right"></i></div> 
            </div>
            <form action="php/postVideo.php" method="POST" id="postVideo" enctype="multipart/form-data">
                <input type="text" id="videoLink" name="videoLink" placeholder="Video link" class="videoLink" autocomplete="off"/>
                 <input type="submit" value="Submit" id="submitRecipe" class="buttonstyle">
            </form>
        </div>
    
        <div class="innerRecipe" style="display: none;">
            <div class="recipeContent"> 
                <div class="popupTitle" style="margin: -1px;">
                    <div id="leftTitle">Post your recipe</div>
                    <div id="rightTitleBack" class="recBack"><i class="fa fa-arrow-right"></i></div>
                </div>
                
                <div id="recipeForm">
                    <form action="php/postRecipe.php" method="POST" id="postRecipeForm" enctype="multipart/form-data">
                        
                        <div id="sectionHeader">
                            <h3>Recipe Title</h3>
                        </div>
                        <div id="titleBody">
                            <input type="text" id="recipeTitle" name="recipeTitle" placeholder="Recipe Title" class="recipeTitle" autocomplete="off"/>
                        </div>
                        
                        <div id="twoHalfsBecomeOne">
                            <div class="sectionHeaderHalf">
                                <h3>Prep Time</h3>
                            </div> 
                            <div class="sectionHeaderHalf">
                                <h3>Cooking Time</h3>
                            </div> 
                            <div class="sectionHeaderHalfServe">
                                <h3>Serves</h3>
                            </div> 
                            <div class="bodyHalf">
                                <input type="text" id="recipePrepTime" name="recipePrepTime" placeholder="" class="recipePrepTime" autocomplete="off" maxlength="2"/>
                                <p style="display: inline; font-size: 0.6em; margin: 0;">hrs</p>
                                <input type="text" id="recipePrepTime" name="recipePrepTime" placeholder="" class="recipePrepTime" autocomplete="off" maxlength="2"/>
                                <p style="display: inline; font-size: 0.6em; margin: 0;">mins</p>
                            </div>
                            <div class="bodyHalf">
                                <input type="text" id="recipeTime" name="recipeTime" placeholder="" class="recipeTime" autocomplete="off" maxlength="2"/>
                                <p style="display: inline; font-size: 0.6em; margin: 0;">hrs</p>
                                <input type="text" id="recipeTime" name="recipeTime" placeholder="" class="recipeTime" autocomplete="off" maxlength="2"/>
                                <p style="display: inline; font-size: 0.6em; margin: 0;">mins</p>
                            </div>
                            <div class="bodyHalfServe">
                                <input type="text" id="recipeServe" name="recipeServe" placeholder="Serves" class="recipeServe" autocomplete="off" maxlength="7"/>
                                <p style="display: inline; font-size: 0.6em; margin: 0;">people</p>
                            </div>
                        </div>
                        
                        <div id="sectionHeader" style="margin-bottom:3px;">
                            <div class="leftHeader">
                                <h3>Ingredients</h3>
                            </div>
                            <div class="rightHeader">
                            
                                <input type="button" id="more_fields" onclick="add_fields();" value="New Ingredient"  class="buttonstyle"/>
                            </div>
                        </div>
                        <div id="ingredientBody">
                            <input type="text" name="recipeIngredients" id="recipeIngredients" placeholder="Recipe Ingredient" class="recipeIngredients" autocomplete="off" maxlength="28"/>
                            <input type="text" name="recipeIngredients" id="recipeIngredients" placeholder="Recipe Ingredient" class="recipeIngredients" style="margin-left: -3px;" maxlength="28"/>
                        </div>
                        
                        <div id="sectionHeader" style="margin-bottom:3px;">
                            <div class="leftHeader">
                                <h3>Instructions</h3>
                            </div>
                            <div class="rightHeader">
                            <input type="button" id="more_fieldsinstuc" onclick="add_fieldsInstruc();" value="New Instruction" class="buttonstyle" /> 
                            </div>
                        </div>
                        <div id="instructionBody">
                            <div id="eachInstruc">
                            <div class="leftInstruc">
                                <p class="number">1</p>
                            </div>
                            <div class="rightInstruc">
                            <textarea name="recipeInstructions" class="recipeInstructions" id="recipeInstructions" maxlength="260" placeholder="Recipe Instructions..." autocomplete="off"></textarea>
                            </div>
                            </div>
                        </div>
                        
                            <br>
                            <center>
                                <p class="guidelineText">Your first recipe? View the <a href="#">Recipe Guideline</a></p>
                            <input type="submit" value="Submit" id="submitRecipe" class="buttonstyle">
                            <input type="button" id="cancel" class="buttonstyle" value="Cancel" /></center>
                    </form>
                </div>
            </div>
        </div>
    </div>