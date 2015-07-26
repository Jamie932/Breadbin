<?php 
	header("Content-Type: application/json", true);
    require("common.php"); 
	
    $data = array();

        $link = $_POST['videoLink'];
        $video_id = explode("?v=", $link); // For videos like http://www.youtube.com/watch?v=...
        if (empty($video_id[1]))
            $video_id = explode("/v/", $link); // For videos like http://www.youtube.com/watch/v/..

        $video_id = explode("&", $video_id[1]); // Deleting any other params
        $video_id = $video_id[0];

        /*
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
*/

        ?>
                    <script>
                        console.log(<? echo json_encode($video_id); ?>);
                    </script>
        <?php

    echo json_encode($data);

?> 