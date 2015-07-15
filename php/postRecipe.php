<?php 
	header("Content-Type: application/json", true);
    require("common.php"); 
	
    $data = array();
    

    ?>
                    <script>
                        console.log(<? echo json_encode($_POST['title']); ?>);
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
            $query = "INSERT INTO posts (userid, type, title)  VALUES (:userid, 'recipe', :text)"; 
            $query_params = array(':userid' => $_SESSION['user']['id'], ':title' => $_POST['title']); 

            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);

            $data['success'] = true;
        }

    echo json_encode($data);
?> 