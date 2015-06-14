<?php
    require("php/common.php");
    if(empty($_SESSION['user'])) 
    {
        header("Location: index.php");
        die("Redirecting to index.php"); 
    }
?>
<html>
<head>
    <title>Bread Bin</title>
    <link href="main.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/jquery.cookie.js"></script>
    <script src="js/checkLogin.js"></script>
</head>
<body>
    <div id="navbar">
        <div class="left">
            <a href="main.html" class="navLinks">Bread Bin</a>
        </div>
        <div class="right">
            <ul>
                <li><a href="" class="navLinks">You</a></li>
                <li><a href="" class="navLinks">Toasted</a></li>
                <li><a href="" class="navLinks">Bill</a></li>
                
            <li><div class="rightnav out"> <!-- Display when logged out.-->
                <a class="navLinks" href="login.html" >Login</a>
            </div></li>
        
            <li><div class="rightnav in"> <!-- Display when logged in.-->
                <a href="profile.html"><img class="minipic" height="32"src="img/profile.png" alt="ProfilePic"></a></li>
            </div>
            </ul>
            
        </div>
    </div>