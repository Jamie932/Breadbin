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
            
        } else if (empty($_POST['ingredients'])) {
            $data['success'] = false;
            $data['error'] = 'Recipes need a ingredients.';
            
        } else if (empty($_POST['instructions'])) {
            $data['success'] = false;
            $data['error'] = 'Recipes need a instructions.';
            
        } else {
            $query = "INSERT INTO posts (userid, type, title, ingred, text)  VALUES (:userid, 'recipe', :text, :ingreds, :text)"; 
            $query_params = array(':userid' => $_SESSION['user']['id'], ':text' => $_POST['title'], ':ingreds' => $_POST['ingredients'], ':text' => $_POST['instructions']); 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);

            $data['success'] = true;
        }

    echo json_encode($data);

?> 