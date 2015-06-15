<?php
    require("php/common.php"); 
                $userID = intval($_GET['id']);
                $query = "SELECT * FROM users WHERE id = :id"; 
                $query_params = array(':id' => $userID); 

                try{ 
                    $stmt = $db->prepare($query); 
                    $result = $stmt->execute($query_params); 
                } 
                catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
                $row = $stmt->fetch();

    if ($row['type'] == "text") {
            echo '<div id="contentPost">';
                echo '<div class="contentPostText">' . $row['text'] . '</div>';
                echo '</div>';
            echo '</div>';
        }
    }
?>