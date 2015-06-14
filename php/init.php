<?php
session_start();

   require("php/common.php");

    if(empty($_SESSION['user'])) 
    {
        header("Location: main.php");
        die("Redirecting to main.php"); 
    } 
?>