<?php
session_start();

   require("php/common.php");

    if(empty($_SESSION['user'])) 
    {
        header("Location: index.php");
        die("Redirecting to index.php"); 
    } 
?>