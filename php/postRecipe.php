<?php 
	header("Content-Type: application/json", true);
    require("common.php"); 
	
    $data = array();
    
    $ingredArray = json_decode($_POST['ingredients']);

        if (empty($_POST['title'])) {
            $data['success'] = false;
            $data['error'] = 'Recipes need a title.';
            
        } else if (ctype_space($_POST['title'])) {
            $data['success'] = false;
            $data['error'] = 'Title cannot contain only spaces.';
            
            
        } else if (empty($_POST['prepTime1']) && empty($_POST['prepTime2'])) {
            $data['success'] = false;
            $data['error'] = 'Recipes need a preperation time.';
        } else if (empty($_POST['prepTime1'])) {
            $prepTimeArray = array("0" , $_POST['prepTime2']);
        } else if (empty($_POST['prepTime2'])) {
            $prepTimeArray = array($_POST['prepTime2'] , "1");
        } else if (ctype_space($_POST['prepTime1']) || ctype_space($_POST['prepTime2'])) {
            $data['success'] = false;
            $data['error'] = 'Prep times cannot contain only spaces.';
            
            
        } else if (empty($_POST['cookTime'])) {
            $data['success'] = false;
            $data['error'] = 'Recipes need a cooking time.';
            
        } else if (ctype_space($_POST['cookTime'])) {
            $data['success'] = false;
            $data['error'] = 'Cook time cannot contain only spaces.';
            
        } else if (empty($_POST['serves'])) {
            $data['success'] = false;
            $data['error'] = 'How many people will it serve.';
            
        } else if (ctype_space($_POST['serves'])) {
            $data['success'] = false;
            $data['error'] = 'Serve cannot contain only spaces.';
            
        } else if (empty($_POST['ingredients'])) {
            $data['success'] = false;
            $data['error'] = 'Recipes need a ingredients.';
            
        } else if (ctype_space($_POST['ingredients'])) {
            $data['success'] = false;
            $data['error'] = 'Ingredients cannot contain only spaces.';
            
        } else if (empty($_POST['instructions'])) {
            $data['success'] = false;
            $data['error'] = 'Recipes need a instructions.';
            
        } else if (ctype_space($_POST['instructions'])) {
            $data['success'] = false;
            $data['error'] = 'Instructions cannot contain only spaces.';
            
        } else {
            $query = "INSERT INTO posts (userid, type, title, prepTime, cookTime, serves, ingred, text)  VALUES (:userid, 'recipe', :text, :prep, :cook, :serves, :ingreds, :instruc)"; 
            $query_params = array(':userid' => $_SESSION['user']['id'], ':text' => $_POST['title'], ':serves' => $_POST['serves'],':ingreds' => $_POST['ingredients'], ':instruc' => $_POST['instructions'], ':prep' => $_POST['prepTime'], ':cook' => $_POST['cookTime']); 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);

            $data['success'] = true;
            
        }

        ?>
                    <script>
                        console.log(<? echo json_encode($prepTimeArray); ?>);
                    </script>
        <?php

    echo json_encode($data);

?> 