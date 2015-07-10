<?php
require("../php/common.php");
require("../php/checkLogin.php");
?>
<html>
<head>
    <title>Breadbin - Discover</title>
    <link href="../css/common.css" rel="stylesheet" type="text/css">
    <link href="../css/navbar.css" rel="stylesheet" type="text/css">
    <link href="../css/discover.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/png" href="../img/favicon.png" />
    <script src="../js/vendor/jquery-1.11.2.min.js"></script>
    <script src="../js/vendor/jquery.cookie.js"></script>
</head>
<body>
    <noscript>
      <META HTTP-EQUIV="Refresh" CONTENT="0;URL=error.php">
    </noscript>    
    
    <?php
require('../php/template/discoverNavbar.php'); 
?>
      
    <div id="categories" style="background-color:#fff">
        <ul class="cats">

			<li class="cats">
                <a href="discover.php">All</a>
            </li>
            <li class="cats">
                <a>Staff Recommendations</a>
            </li>
            <li class="cats">
                <a class="active">Top Posts</a>
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
            $query        = "SELECT * FROM posts WHERE userid NOT IN (SELECT user_no FROM following WHERE follower_id = :id) ORDER BY toasts";
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
        
        $direcFix = '../'.$row['image'];
            
        if ($row['type'] == "image") {
            list($width, $height) = getimagesize($direcFix);
            
            $aspectRatio = $width / $height;
            $testHeight  = $height / 2;
            $testWidth   = $width / 2;
            
            echo '<li>';
            echo '<div class="banner">';
            
            if ($aspectRatio >= 0) {
                if ($height >= 0 && $height < 99) {
                    echo '<img class="tiles" src="' . $direcFix . '" height="100px">';
                } else if ($height >= 100 && $height < 200) {
                    echo '<img class="tiles" src="' . $direcFix . '" height="' . $height . '">';
                } else if ($height >= 200 && $height < 300) {
                    echo '<img class="tiles" src="' . $direcFix . '" height="' . $height . '">';
                } else if ($height >= 300 && $height < 350) {
                    echo '<img class="tiles" src="' . $direcFix . '" height="' . $height . '">';
                } else if ($height >= 350 && $height < 400) {
                    echo '<img class="tiles" src="' . $direcFix . '" height="' . $height . '"';
                } else if ($height >= 400 && $height < 500) {
                    echo '<img class="tiles" src="' . $direcFix . '" height="' . $height . '">';
                } else if ($height >= 500 && $height < 600) {
                    echo '<img class="tiles" src="' . $direcFix . '" height="400px">';
                } else if ($height >= 600 && $height < 700) {
                    echo '<img class="tiles" src="' . $direcFix . '" height="400px">';
                } else if ($height >= 700 && $height < 800) {
                    echo '<img class="tiles" src="' . $direcFix . '" height="400px">';
                } else if ($height >= 800 && $height < 1000) {
                    echo '<img class="tiles" src="' . $direcFix . '" height="' . $testHeight . '">';
                } else if ($height >= 1000) {
                    echo '<img class="tiles" src="' . $direcFix . '" height="400px">';
                } else {
                    echo '<img class="tiles" src="' . $direcFix . '" height="400px">';
                }
            } else if ($aspectRatio == 1) {
                if ($height >= 0 && $height < 100) {
                    echo '<img class="tiles" src="' . $direcFix . '" height="100px">';
                } else if ($height >= 100 && $height < 400) {
                    echo '<img class="tiles" src="' . $direcFix . '" height="' . $height . '">';
                } else if ($height >= 400) {
                    echo '<img class="tiles" src="' . $direcFix . '" height="400px">';
                }
            } else {
                echo '<img class="tiles" src="' . $direcFix . '" height="220px" width="300px">';
            }
            
            echo '</div>';
            
            echo '<div class="postUsername">';
                echo '<a href="../profile.php?id=' . $row['userid'] . '">@' . $test['username'] .'</a>';
            echo '</div>';
            
            echo '</li>'; 
            
        } else if ($row['type'] == "text") {
            echo '<li><div class="box"><p class="textPost">' . $row['text'] . '</p>';
                echo '<div class="postUsername">';
                    echo '<a href="../profile.php?id=' . $row['userid'] . '">@' . $test['username'] .'</a>';
                echo '</div>';
            echo '</div></li>';
        }
        
        else if ($row['type'] == 'imagetext') {
            list($width, $height) = getimagesize($direcFix);
            
            $aspectRatio = $width / $height;
            $testHeight  = $height /= 2; 
            
            echo '<li>';
            echo '<div class="banner">';
            
            if ($height <= 200) {
                echo '<img class="blurImage" src="' . $direcFix . '" height="' . $height . '" width="300px">';
            } else if ($aspectRatio >= 0) {
                if ($height >= 0 && $height < 100) {
                    echo '<img class="blurImage" src="' . $direcFix . '" height="' . $height . '" width="300px">';
                } else if ($height >= 100 && $height < 200) {
                    echo '<img class="blurImage" src="' . $direcFix . '" height="' . $height . '" width="300px">';
                } else if ($height >= 300 && $height < 350) {
                    echo '<img class="blurImage" src="' . $direcFix . '" height="' . $height . '" width="300px">';
                } else if ($height >= 350 && $height < 400) {
                    echo '<img class="blurImage" src="' . $direcFix . '" height="' . $height . '" width="300px">';
                } else if ($height >= 400 && $height < 500) {
                    echo '<img class="blurImage" src="' . $direcFix . '" height="' . $height . '" width="300px">';
                } else if ($height >= 500 && $height < 600) {
                    echo '<img class="blurImage" src="' . $direcFix . '" height="400px" width="300px">';
                } else if ($height >= 600 && $height < 1000) {
                    echo '<img class="blurImage" src="' . $direcFix . '" height="400px" width="300px">';
                } else if ($height >= 1000) {
                    echo '<img class="blurImage" src="' . $direcFix . '" height="400px" width="300px">';
                }
            } else if ($aspectRatio == 1) {
                if ($height >= 0 && $height < 100) {
                    echo '<img class="blurImage" src="' . $direcFix . '" height="100px">';
                } else if ($height >= 100 && $height < 400) {
                    echo '<img class="blurImage" src="' . $direcFix . '" height="' . $height . '">';
                } else if ($height >= 400) {
                    echo '<img class="blurImage" src="' . $direcFix . '" height="400px" width="300px">';
                }
            } else {
                echo '<img class="blurImage" src="' . $direcFix . '" width="300px" height="220px">';
            }
            
            
            
            echo '<div class="bannerText">';
                echo $row['text'];
            echo '</div>';
            
            echo '</div>';
            
             /*echo '<div class="postTitle">';
                echo 'Recipie title';
            echo '</div>';*/
            
            echo '<div class="postUsername">';
                echo '<a href="../profile.php?id=' . $row['userid'] . '">@' . $test['username'] .'</a>';
            echo '</div>';
            
            echo '<div class="postText">';
                echo '<img src="../img/text.png" height="30px">';
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
        <script src="../js/vendor/jquery.wookmark.js"></script>
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