<?php

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$id = $_SESSION['user']['id'];

$A = count($item_name);

include ("common.php");

try {

    $set_details = "UPDATE users
                    SET firstname = :firstname,
                    lastname = :lastname
                    email = :email
                    WHERE id = :id";


    $STH = $conn->prepare($set_details);

    $i = 0;
    while($i < $A) {
        $STH->bindParam(':firstname', $firstname[$i]);
        $STH->bindParam(':lastname', $lastname[$i]);
        $STH->bindParam(':email', $email[$i]);
        $STH->execute();
        $i++;
    }
}
catch(PDOException $e) {  
    echo "I'm sorry, but there was an error updating the database.";  
    file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
}


?>