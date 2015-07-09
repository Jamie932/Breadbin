<?php
require("php/common.php");
require("php/checkLogin.php");
?>
<html>
<head>
    <title>Breadbin - Discover</title>
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/discover.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="js/vendor/jquery-1.11.2.min.js"></script>
    <script src="js/vendor/jquery.cookie.js"></script>
</head>
<body>
    <noscript>
      <META HTTP-EQUIV="Refresh" CONTENT="0;URL=error.php">
    </noscript>    
    
    <?php
require('php/template/navbar.php');
?>
    
    <?php
/*$query = "SELECT colour FROM user_settings WHERE user_id = :userId"; 
$query_params = array(':userId' => $_SESSION['user']['id']); 

$stmt = $db->prepare($query); 
$result = $stmt->execute($query_params); 
$row = $stmt->fetch();

if($row){ 
if ($row['colour'] == 1) {
$newColour = '#AFE4AF;';
$fontColour = '#000';
} else if ($row['colour'] == 2){
$newColour = '#81ABFF';
} else if ($row['colour'] == 3){
$newColour = '#FFC46C';
} else if ($row['colour'] == 4){
$newColour = '#FF93DB';
}
}
*/
?>

                <script>
                    console.log(<?
echo json_encode($newColour);
?>); 
                </script>

        <?php

echo '<div id="categories" style="background-color:#fff">';
echo '<ul class="cats" style="color:' . $fontColour . '">';
?>
    
			<li class="cats">
                <a href="#">Staff Recommendations</a>
            </li>
            <li class="cats">
                <a href="#">Top Posts</a>
            </li>
            <li class="cats">
                <a href="#">Just Pictures</a>
            </li>
            <li class="cats">
                <a href="#">Just Recipies</a>
            </li>
		</ul>
    </div>
        
    <div id="content">
        <div id="main">
            <?php
            $query        = "SELECT * FROM posts WHERE userid NOT IN (SELECT user_no FROM following WHERE follower_id = :id) ORDER BY RAND()";
            /*userid <> :id AND */
            $query_params = array(':id' => $_SESSION['user']['id']);
            $stmt         = $db->prepare($query);
            $result       = $stmt->execute($query_params);
            $posts        = $stmt->fetchAll();

        if (!$posts) {
            echo '<center>You follow everyone tough luck.</center>';
        } else {
        foreach ($posts as $row) {
            
            $query        = "SELECT username FROM users WHERE id = :id"; 
            $query_params = array(':id' => $row['userid']);
            $stmt         = $db->prepare($query);
            $result       = $stmt->execute($query_params);
            $test         = $stmt->fetch();
            
        echo '<ul id="tiles">';
        
        if ($row['type'] == "image") {
            list($width, $height) = getimagesize($row['image']);
            
            $aspectRatio = $width / $height;
            $testHeight  = $height / 2;
            
            echo '<li>';
            echo '<div class="banner">';
            
            if ($aspectRatio >= 0) {
                if ($height >= 0 && $height < 99) {
                    echo '<img class="tiles" src="' . $row['image'] . '" height="100px">';
                } else if ($height >= 100 && $height < 200) {
                    echo '<img class="tiles" src="' . $row['image'] . '" height="' . $height . '">';
                } else if ($height >= 200 && $height < 300) {
                    echo '<img class="tiles" src="' . $row['image'] . '" height="' . $height . '">';
                } else if ($height >= 300 && $height < 350) {
                    echo '<img class="tiles" src="' . $row['image'] . '" height="' . $height . '">';
                } else if ($height >= 350 && $height < 400) {
                    echo '<img class="tiles" src="' . $row['image'] . '" height="' . $height . '"';
                } else if ($height >= 400 && $height < 500) {
                    echo '<img class="tiles" src="' . $row['image'] . '" height="' . $height . '">';
                } else if ($height >= 500 && $height < 600) {
                    echo '<img class="tiles" src="' . $row['image'] . '" height="400px">';
                } else if ($height >= 600 && $height < 700) {
                    echo '<img class="tiles" src="' . $row['image'] . '" height="400px">';
                } else if ($height >= 700 && $height < 800) {
                    echo '<img class="tiles" src="' . $row['image'] . '" height="400px">';
                } else if ($height >= 800 && $height < 1000) {
                    echo '<img class="tiles" src="' . $row['image'] . '" height="' . $testHeight . '">';
                } else if ($height >= 1000) {
                    echo '<img class="tiles" src="' . $row['image'] . '" height="400px">';
                } else {
                    echo '<img class="tiles" src="' . $row['image'] . '" height="400px">';
                }
            } else if ($aspectRatio == 1) {
                echo '<img class="tiles" src="' . $row['image'] . '" height="300px" width="300px">';
            } else {
                echo '<img class="tiles" src="' . $row['image'] . '" height="220px" width="300px">';
            }
            
            echo '<div class="postUsername">';
                echo '<a href="profile.php?id=' . $row['userid'] . '">@' . $test['username'] .'</a>';
            echo '</div>';
            
            echo '</div>';
            echo '</li>'; 
            
        } else if ($row['type'] == "text") {
            echo '<li><div class="box"><p class="textPost">' . $row['text'] . '</p>';
                echo '<div class="postUsername">';
                    echo '<a href="profile.php?id=' . $row['userid'] . '">@' . $test['username'] .'</a>';
                echo '</div>';
            echo '</div></li>';
        }
        
        else if ($row['type'] == 'imagetext') {
            list($width, $height) = getimagesize($row['image']);
            
            $aspectRatio = $width / $height;
            $testHeight  = $height /= 2; 
            
            echo '<li>';
            echo '<div class="banner">';
            
            if ($height <= 200) {
                echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '" width="300px">';
            } else if ($aspectRatio >= 0) {
                if ($height >= 0 && $height < 100) {
                    echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '" width="300px">';
                } else if ($height >= 100 && $height < 200) {
                    echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '" width="300px">';
                } else if ($height >= 300 && $height < 350) {
                    echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '" width="300px">';
                } else if ($height >= 350 && $height < 400) {
                    echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '" width="300px">';
                } else if ($height >= 400 && $height < 500) {
                    echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '" width="300px">';
                } else if ($height >= 500 && $height < 600) {
                    echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '" width="300px">';
                } else if ($height >= 600 && $height < 1000) {
                    echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '" width="300px">';
                } else if ($height >= 1000) {
                    echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '" width="300px">';
                }
            } else if ($aspectRatio == 1) {
                echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $testHeight . '"">';
            } else {
                echo '<img class="blurImage" src="' . $row['image'] . '" width="300px" height="220px">';
            }
            
            echo '<div class="postUsername">';
                echo '<a href="profile.php?id=' . $row['userid'] . '">@' . $test['username'] .'</a>';
            echo '</div>';
            
            echo '<div class="bannerText">';
            echo $row['text'];
            echo '</div>';
            
            echo '</div>';
            echo '</li>';
        }
        echo '</ul>';
    }
}
?>
               
               </ul>
            </div>
        </div>
        <footer>
                <center>Will we ever have a footer?</center>
        </footer>
        <script src="js/jquery.wookmark.js"></script>
        <script type="text/javascript">
        var colors = [
            "rgb(138, 230, 138)",
            "rgb(102, 153, 255)",
            "rgb(255, 181, 64)",
            "rgb(255, 102, 204)"
        ];

        var boxes = document.querySelectorAll(".box");

        for (i = 0; i < boxes.length; i++) {
          // Pick a random color from the array 'colors'.
          boxes[i].style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
          boxes[i].style.width = '300';
          boxes[i].style.height = '230';
          boxes[i].style.display = 'inline-table';
          boxes[i].style.margin = '0';
          boxes[i].style.textAlign = 'center';
          boxes[i].style.verticalAlign = 'middle';
          boxes[i].style.position = 'relative';
        }

        $(document).ready(new function() {
          // Prepare layout options.
          var options = {
            autoResize: true, // This will auto-update the layout when the browser window is resized.
            container: $('#main'), // Optional, used for some extra CSS styling
            offset: 5, // Optional, the distance between grid items
            itemWidth: 310 // Optional, the width of a grid item
          };

          // Get a reference to your grid items.
          var handler = $('#tiles li');

          // Call the layout function.
          handler.wookmark(options);

          // Capture clicks on grid items.
         
        });
    </script>
</body>
</html>