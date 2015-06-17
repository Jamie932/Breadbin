<?php 
        require("common.php"); 

                $userID = intval($_GET['id']);
                $query = "SELECT * FROM users WHERE id = :id"; 
                $query_params = array(':id' => $userID); 

                $stmt = $db->prepare($query); 
                $result = $stmt->execute($query_params);
                $row = $stmt->fetch();

                if($row){ 
                    echo 'User ID: ' . $row['id'] . '<br>';
                    echo 'Username: ' . $row['username'] . '<br>';
                    echo 'Email: ' . $row['email'];
                } else {
                    echo "<div id=\"errormsg\"> User not found </div>";
                }
?>