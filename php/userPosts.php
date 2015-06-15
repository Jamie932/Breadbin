<?php
    require("common.php"); 
	
    foreach ($posts as $row) {
		$query = "SELECT * FROM users WHERE id = :id"; 
		$query_params = array(':id' => $_SESSION['user']['id']); 
        
    try{ 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 
		$userrow = $stmt->fetch();
		$username = 'Unknown';

    if ($row['type'] == "text") {
            echo '<div id="contentPost">';
                echo '<div class="contentPostText">' . $row['text'] . '</div>';
                echo '</div>';
            echo '</div>';
        }
    }
?>