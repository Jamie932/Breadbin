<?php 
    require("php/common.php");
    require("php/checkLogin.php");
?>
<html>
<head>
    <title>Breadbin - Home</title>
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/discover.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/jquery.cookie.js"></script>
</head>
<body>
    <noscript>
      <META HTTP-EQUIV="Refresh" CONTENT="0;URL=error.php">
    </noscript>    
    
    <?php require('php/template/navbar.php'); ?>
    
    <div id="content">
    <div id="main">
            <?php
                $query = "SELECT * FROM posts WHERE userid <> :id AND userid NOT IN (SELECT user_no FROM following WHERE follower_id = :id) ORDER BY RAND()";
                $query_params = array(':id' => $_SESSION['user']['id']); 
                $stmt = $db->prepare($query); 
                $result = $stmt->execute($query_params); 
                $posts = $stmt->fetchAll();
                
             if (!$posts) {
                 echo '<center>You follow everyone tough luck.</center>';
             } else {
                foreach ($posts as $row) {
                echo '<ul id="tiles">';

                if ($row['type'] == "image") {
                    $imgName = ltrim($row['image'], "/.");
                    list($width, $height) = getimagesize($imgName);

                    $aspectRatio = $width/$height;
                    $testHeight = $height/=2;
                ?>

                <script>
                    console.log(<? echo json_encode($aspectRatio); ?>);
                </script>

                <?php
                    if ($aspectRatio >= 0) {
                        if ($height >=0 && $height < 99) {
                            echo '<li><img class="tiles" src="' . $row['image'] . '" height="100px"></li>'; 
                        } else if ($height >= 100 && $height < 200) {
                            echo '<li><img class="tiles" src="' . $row['image'] . '" height="' . $height . '"></li>'; 
                        } else if ($height >= 200 && $height < 300) {
                            echo '<li><img class="tiles" src="' . $row['image'] . '" height="' . $height . '"></li>'; 
                        } else if ($height >= 300 && $height < 350) {
                            echo '<li><img class="tiles" src="' . $row['image'] . '" height="' . $height . '"></li>'; 
                        } else if ($height >= 350 && $height < 400) {
                            echo '<li><img class="tiles" src="' . $row['image'] . '" height="' . $height . '"></l>'; 
                        } else if ($height >= 400 && $height < 500) {
                            echo '<li><img class="tiles" src="' . $row['image'] . '" height="' . $height . '"></li>'; 
                        } else if ($height >= 500 && $height < 600) {
                            echo '<li><img class="tiles" src="' . $row['image'] . '" height="400px"></li>'; 
                        } else if ($height >= 700 && $height < 800) {
                            echo '<li><img class="tiles" src="' . $row['image'] . '" height="' . $testHeight . '"></li>'; 
                        } else if ($height >= 800 && $height < 1000) {
                            echo '<li><img class="tiles" src="' . $row['image'] . '" height="' . $testHeight . '"></li>'; 
                        } else if ($height >= 1000) {
                            echo '<li><img class="tiles" src="' . $row['image'] . '" height="400px"></li>'; 
                        } else {
                            echo '<li><img class="tiles" src="' . $row['image'] . '" height="400px"></li>'; 
                        }
                    } else if ($aspectRatio == 1) {
                        echo '<li><img class="tiles" src="' . $row['image'] . '" height="300px" width="300px"></li>'; 
                    } else {
                        echo '<li><img class="tiles" src="' . $row['image'] . '" height="220px" width="300px"></li>'; 
                    }

                } else if ($row['type'] == "text") {
                        echo '<li><div class="box"><p class="textPost">' . $row['text'] . '</p></div></li>';

                } else if ($row['type'] == 'imagetext') {
                    $imgName = ltrim($row['image'], "/.");
                    list($width, $height) = getimagesize($imgName);

                    $aspectRatio = $width/$height;
                    $testHeight = $height/=2;

                ?>

                <script>
                    console.log(<? echo json_encode($aspectRatio); ?>);
                </script>

                <?php
                    echo '<li>';
                    echo '<div class="banner">';

                    if ($height <= 200) {
                        echo '<img class="blurImage" src="' . $row['image'] . '" height="' .$height. '" width="300px">'; 
                    } else if ($aspectRatio >= 0) {
                        if ($height >=0 && $height < 100) {
                            echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '" width="300px">'; 
                        } else if ($height >=100 && $height < 200) {
                            echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '" width="300px">'; 
                        } else if ($height >=300 && $height < 350) {
                            echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '" width="300px">'; 
                        } else if ($height >=350 && $height < 400) {
                            echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '" width="300px">'; 
                        } else if ($height >=400 && $height < 500) {
                            echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '" width="300px">'; 
                        } else if ($height >=500 && $height < 600) {
                            echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '" width="300px">'; 
                        } else if ($height >=600 && $height < 1000) {
                            echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '" width="300px">'; 
                        } else if ($height >=1000) {
                            echo '<img class="blurImage" src="' . $row['image'] . '" height="' . $height . '" width="300px">'; 
                        }
                    } else if ($aspectRatio == 1) {
                        echo '<img class="blurImage" src="' . $row['image'] . '" height="'. $testHeight .'"">'; 
                    } else {
                        echo '<img class="blurImage" src="' . $row['image'] . '" width="300px" height="220px">';
                    } 

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