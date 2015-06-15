<?php 

function hasHash() {
    if(isset($_COOKIE['hashkey'])) {
        return true;
    }
    return false;
}

    if (hasHash()) {
        $hash = $_COOKIE['hashkey'];

        $query = "SELECT userid, hash FROM uniquelogs WHERE hash = :hash"; 
        $query_params = array(':hash' => $hash); 

        try{ 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 
        $row = $stmt->fetch();

        if ($row) {
            unset($_COOKIE['hashkey']);

            $newHash = md5(uniqid(rand(), true));
            setcookie( "hashkey", $newHash, (time()+ 60 * 60 * 24 * 30) ); 

            $query = "UPDATE uniquelogs SET hash = :hash WHERE userid = :userid"; 
            $query_params = array(':hash' => $newHash, ':userid' => $row['userid']); 

            try{ 
                $stmt = $db->prepare($query); 
                $result = $stmt->execute($query_params); 
            } 
            catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }         

            if ($_SERVER['REQUEST_URI'] == "/index.php") {
                header("Location: main.php");
            }

        } else {
            header("Location: index.php");
        }

    } else {
        header("Location: index.php");
    }

?> 