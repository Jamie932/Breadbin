<?php
   /* require("php/common.php");
    if(empty($_SESSION['user'])) 
    {
        header("Location: index.php");
        die("Redirecting to index.php"); 
    }*/
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
                <a href="profile.html"><img class="minipic" height="32"src="profile.png" alt="ProfilePic"></a></li>
            </div>
            </ul>
            
        </div>
    </div>
    
    
    <div id="break"></div>
    
    <div id="left"></div>
    
<div id="center">
    <div id="sidebar">
        <div class="upload">
            <div class="textarea">
                <form action="" id="upload">
                    <textarea name="TextUpload" id="uploadText" maxlength="150" placeholder="Have your say..."></textarea>
                </form>
            </div>
            <div class="uploadRest">
                <a><img src="cat.jpg" height="40px" width="40px"></a>
                <a><img src="cat.jpg" height="40px" width="40px"></a>
                <a><img src="cat.jpg" height="40px" width="40px"></a>
                <a><img src="cat.jpg" height="40px" width="40px"></a>
                <img src="cat.jpg" height="40px" width="60px" style="margin-left: 43px;">
            </div>
        </div>  
        <div id="placehold">
            jkfsgjslkfgjskldfjglskfdgjkjflkgjsldfkgj
            jkfsgjslkfgjskldfjglskfdgjkjflkgjsldfkgj
            jkfsgjslkfgjskldfjglskfdgjkjflkgjsldfkgj
            jkfsgjslkfgjskldfjglskfdgjkjflkgjsldfkgj
            jkfsgjslkfgjskldfjglskfdgjkjflkgjsldfkgj
            jkfsgjslkfgjskldfjglskfdgjkjflkgjsldfkgj
            jkfsgjslkfgjskldfjglskfdgjkjflkgjsldfkgj
            jkfsgjslkfgjskldfjglskfdgjkjflkgjsldfkgj
            jkfsgjslkfgjskldfjglskfdgjkjflkgjsldfkgj
            jkfsgjslkfgjskldfjglskfdgjkjflkgjsldfkgj
            jkfsgjslkfgjskldfjglskfdgjkjflkgjsldfkgj
            jkfsgjslkfgjskldfjglskfdgjkjflkgjsldfkgj
        </div>
    </div>
    
    <div id="content">
        <div id="contentPost">
            <div class="contentPostImage">
            </div>
            <div class="contentPostInfo">
                <div id="contentInfoText">
                    <div class="left">
                        UsernameGoesHere
                    </div>
                    <div class="right">
                        2mins
                    </div>
                </div>
            </div>
        </div>
        <div id="contentLike">
            <P>Toast</P>
            <P>Burn</P>
            <P class="report">Report</P>
        </div>
        
        <br>
        
        <div id="contentPost">
            <div class="contentPostText">
                . 
            </div>
            <div class="contentPostInfo">
                <div id="contentInfoText">
                    <div class="left">
                        UsernameGoesHere
                    </div>
                    <div class="right">
                        4hrs
                    </div>
                </div>
            </div>
        </div>
        <div id="contentLike">
            <P>Toast</P>
            <P>Burn</P>
            <P class="report">Report</P>
        </div>
        
        <br>
        
         <div id="contentPost">
            <div class="contentPostImage">
            </div>
            <div class="contentPostInfo">
                <div id="contentInfoText">
                    <div class="left">
                        UsernameGoesHere
                    </div>
                    <div class="right">
                        4hrs
                    </div>
                </div>
            </div>
        </div>
        
        <div id="contentLike">
            <P>Toast</P>
            <P>Burn</P>
            <P class="report">Report</P>
        </div>
        
        <br>
        
    </div>
</div>
    <div id="right"></div>
</body>
</html>