<?php 
	header("Content-Type: application/json", true);
    require("common.php"); 
	
    $data = array();

        $url = $_POST['videoLink'];
        parse_str( parse_url( $url, PHP_URL_QUERY ), $videoId );

        if (empty($_POST['videoLink'])) {
            $data['success'] = false;
            $data['error'] = 'Recipes need a video.';
            
        } else if (ctype_space($_POST['videoLink'])) {
            $data['success'] = false;
            $data['error'] = 'Video cannot contain only spaces.';

        } else {
            
            $query = "INSERT INTO posts (userid, type, text)  VALUES (:userid, 'video', :idVideo)"; 
            $query_params = array(':userid' => $_SESSION['user']['id'], ':idVideo' => $videoId);  
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);

            $data['success'] = true;
            
        }

        ?>
                    <script>
                        console.log(<? echo json_encode($my_array_of_vars); ?>);
                    </script>
        <?php

    echo json_encode($data);

?> 