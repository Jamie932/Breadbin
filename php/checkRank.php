<?php 
    if (empty($_SESSION['user']['rank']) || ($_SESSION['user']['rank'] == "user")) {
        header('Location: errorFile.php?error=403');
    }
?> 