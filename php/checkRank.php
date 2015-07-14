<?php 
    if (empty($_SESSION['user']['rank']) || ($_SESSION['user']['rank'] == "user")) {
        header('HTTP/1.0 403 Forbidden');
        header('Location: errorFile.php');
    }
?> 