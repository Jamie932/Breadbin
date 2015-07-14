<?php 
    if (empty($_SESSION['user']['rank']) || ($_SESSION['user']['rank'] == "user")) {
        header("X-PHP-Response-Code: 403", true, 403);
    }
?> 