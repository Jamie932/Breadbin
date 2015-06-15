<?php 
        require("php/common.php"); 

        foreach ($posts as $row) {
            $query = "SELECT * FROM posts WHERE id = :id"; 
            $query_params = array(':id' => $row['userid']); 

            try{ 
                $stmt = $db->prepare($query); 
                $result = $stmt->execute($query_params); 
            } 
            catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 
            $userrow = $stmt->fetch();
            $username = 'Unknown';

        if ($row['type'] == "text") {
            echo '<div class="contentPostText">' . $row['text'] . '</div>';
        }
	}
        } else {
            echo "<div id=\"errormsg\"> User not found </div>";
        }
?>