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
            <a href="main.php" class="navLinks">Bread Bin</a>
        </div>
        <div class="right"
                
            <li>
                <a class="navLinks" href="profile.php" >Profile</a>
            </li>

            </ul>
            
        </div>
    </div>
    
    
    <div id="break"></div>
    
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
            <h5>Recommended toasters</h5>
            <div class="userRecom">
               <a href="" class="usernameRecom"><img src="cat.jpg" height="50px" width="50px">
                    Username
                </a>
            </div>
            <div class="userRecom">
                 <a href="" class="usernameRecom"><img src="cat.jpg" height="50px" width="50px">
                    Username
                </a>
            </div>
             <div class="userRecom">
                 <a href="" class="usernameRecom"><img src="cat.jpg" height="50px" width="50px">
                    Username
                </a>
            </div>
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
</body>
</html>