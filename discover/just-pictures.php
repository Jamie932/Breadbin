<!DOCTYPE html>
<?php
require("../php/common.php");
require("../php/checkLogin.php");
require("../php/vendor/ImageResize.php");
?>
<html>
<head>
    <title>Breadbin - Discover</title>
    <link href="../css/common.css" rel="stylesheet" type="text/css">
    <link href="../css/navbar.css" rel="stylesheet" type="text/css">
    <link href="../css/discover.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="../img/favicon.png" />
    <script src="../js/vendor/jquery-1.11.2.min.js"></script>
    <script src="../js/vendor/jquery.cookie.js"></script>
    <script src="../js/vendor/jquery.unveil.js"></script>
    
    <script>
    $(document).ready(function(){
        // to fade out before redirect
        $('a').click(function(e){
            redirect = $(this).attr('href');
            e.preventDefault(); 
            $('#content').fadeOut(400, function(){
                document.location.href = redirect
            });
        });
    })    
    
    $(document).ready(function() {
        $(window).load(function() {
            $('#loader').hide();

            $('#content').animate({opacity: 1}, 600);
            $('#content').css("pointer-events", "auto");
        });
    });
      
    $(document).ready(function() {
        $(function() {
            $("img.tiles").unveil(300);
        });
    });
    </script>
    
</head>
<body>
    <noscript>
      <META HTTP-EQUIV="Refresh" CONTENT="0;URL=error.php">
    </noscript>          
    
    <?php
    require('../php/template/discoverNavbar.php'); 
    ?>
       
    <div id="loader">
        <i class="fa fa-spinner fa-pulse" style="font-size: 5em; pointer-events: none;"></i>
        <p>Loading some beautiful content...</p> 
    </div>
      
    <div id="categories" style="background-color:#fff">
        <ul class="cats">

			<li class="cats">
                <a href="discover.php">All</a>
            </li>
            <li class="cats">
                <a href="staff-recom.php">Staff Recommendations</a>
            </li>
            <li class="cats">
                <a href="top-posts.php">Top Posts</a>
            </li>
            <li class="cats">
                <a class="active">Just Pictures</a>
            </li>
            <li class="cats">
                <a href="just-recipes.php">Just Recipes</a>
            </li>
            
		</ul>
    </div>
        
    <div id="content">
        <div id="main">
            <?php
            $query        = "SELECT * FROM posts WHERE type = 'image' AND userid NOT IN (SELECT user_no FROM following WHERE follower_id = :id) ORDER BY RAND()";
            /*userid <> :id AND */
            $query_params = array(':id' => $_SESSION['user']['id']);
            $stmt         = $db->prepare($query);
            $result       = $stmt->execute($query_params);
            $posts        = $stmt->fetchAll();

        if (!$posts) {
            echo '<center>Nothing to discover.</center>';
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
            $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $direcFix);
            $imageLocation = $withoutExt . '-profile.jpg';

            echo '<li>';
            echo '<div class="banner">';                
            echo '<img class="tiles" src="' . $imageLocation . '"';
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
            $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $direcFix);
            $imageLocation = $withoutExt . '-profile.jpg';

            echo '<li>';
            echo '<div class="banner">';                
            echo '<img class="blurImage" src="' . $imageLocation . '"';
            echo '</div>';
            
            echo '<div class="postUsername">';
                echo '<a href="../profile.php?id=' . $row['userid'] . '">@' . $test['username'] .'</a>';
            echo '</div>';
            
            echo '<div class="postTitle">';
                echo 'Recipie title';
            echo '</div>';
            
            echo '<div class="postText">';
                echo '<img src="../img/text.png" height="27px">';
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