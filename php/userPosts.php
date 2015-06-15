<?php 
        require("common.php"); 

                $userID = intval($_GET['id']);
                $query = "SELECT * FROM users WHERE id = :id"; 
                $query_params = array(':id' => $userID); 

                try{ 
                    $stmt = $db->prepare($query); 
                    $result = $stmt->execute($query_params); 
                } 
                catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
                $row = $stmt->fetch();

                if($row){ 
                    echo 'User ID: ' . $row['id'] . '<br>';
                    echo 'Username: ' . $row['username'] . '<br>';
                    echo 'Email: ' . $row['email'];
                } else {
                    echo "<div id=\"errormsg\"> User not found </div>";
                }
?>