<?php 
    require("php/common.php");

        $query = "SELECT * FROM users WHERE id = :id"; 
        $query_params = array(':id' => $_SESSION['user']['id']); 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
        $randUser = $stmt->fetchAll();

        $currentID = $_SESSION['user']['id'];
        
        $query = "SELECT * FROM user_settings WHERE user_id = :id"; 
        $query_params = array(':id' => $_SESSION['user']['id']); 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
        $row = $stmt->fetch();

        if($row){ 
            if ($row['colour'] == 2) {
                $colour = 'rgba(102, 153, 255, 0.2)';
            } else if ($row['colour'] == 3) {
                $colour = 'rgba(0, 197, 30, 0.2)';
            } else if ($row['colour'] == 4) {
                $colour = 'rgba(236, 88, 88, 0.2)';
            } else if ($row['colour'] == 5) { 
                $colour = 'rgba(140, 104, 216, 0.2)';
            } else if ($row['colour'] == 6) {
                $colour = 'rgba(204, 122, 176, 0.2)';
			} else if ($row['colour'] == 7) { 
                $colour = 'rgba(54, 54, 54, 0.2)';
			} else {
                $colour = 'rgba(246, 166, 40, 0.2)';
            }
        }
?>

<div id="gridBox">
        <div class="innerGrid">
        <div class="popupTitleTest" style="margin: -1px;">
            <div id="leftUserImg">
                <?php 
                    if (!file_exists('img/avatars/' . $currentID . '/avatar.jpg')) {
                        echo '<img src="img/profile2.png" height="70px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    } else { 
                        echo '<img src="img/avatars/' . $currentID . '/avatar.jpg" height="70" width="70px" style="border-radius:50%; border: 1px solid ' .$colour. '">';
                    }
                ?>
            </div>
                    <div id="rightTitleRec"><i class="fa fa-times" style="color: black;"></i></div>
        </div>
            <div class="gridBoxes 1">
                <center><i class="fa fa-cutlery" style="font-size: 6em; margin-bottom: 17px; margin-top: 12px;"></i><br>
                Recipe</center>
            </div>
            <div class="gridBoxes 2">
            <center><i class="fa fa-video-camera" style="font-size: 6em; margin-bottom: 17px; margin-top: 12px;"></i><br>
            Video</center>
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