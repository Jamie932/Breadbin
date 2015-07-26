<?php 
	header("Content-Type: application/json", true);
    require("common.php"); 
	
    $data = array();

        $url  = $_POST['videoLink'];
        $keys = parse_url($url); // parse the url
        $path = explode("watch?v=", $keys['path']); // splitting the path
        $last = end($path); // get the value of the last element 

        if (empty($_POST['videoLink'])) {
            $data['success'] = false;
            $data['error'] = 'Recipes need a video.';
            
        } else if (ctype_space($_POST['videoLink'])) {
            $data['success'] = false;
            $data['error'] = 'Video cannot contain only spaces.';

        } else {
            
            $query = "INSERT INTO posts (userid, type, text)  VALUES (:userid, 'video', 'ignore4now')"; 
            $query_params = array(':userid' => $_SESSION['user']['id']);  
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);

            $data['success'] = true;
            
        }

        ?>
                    <script>
                        console.log(<? echo json_encode($last); ?>);
                    </script>
        <?php

    echo json_encode($data);

?> 