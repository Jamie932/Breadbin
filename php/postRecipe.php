<?php 
	header("Content-Type: application/json", true);
    require("common.php"); 
	
    $data = array();
    
    $ingredArray = json_decode($_POST['ingredients']);

    ?>
                    <script>
                        console.log(<? echo json_encode($ingredArray); ?>);
                    </script>
    <?php

        if (empty($_POST['title'])) {
            $data['success'] = false;
            $data['error'] = 'Recipes need a title.';
            
        } else if (ctype_space($_POST['title'])) {
            $data['success'] = false;
            $data['error'] = 'Title cannot contain only spaces.';
            
        } else if (empty($_POST['time'])) {
            $data['success'] = false;
            $data['error'] = 'Recipes need a time.';
            
        } else if (ctype_space($_POST['time'])) {
            $data['success'] = false;
            $data['error'] = 'Time cannot contain only spaces.';
            
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
            $query = "INSERT INTO posts (userid, type, title, ingred, text)  VALUES (:userid, 'recipe', :text, :ingreds, :instruc)"; 
            $query_params = array(':userid' => $_SESSION['user']['id'], ':text' => $_POST['title'], ':ingreds' => $_POST['ingredients'], ':instruc' => $_POST['instructions']); 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);

            $data['success'] = true;
            
        }

    echo json_encode($data);

?> 