<!DOCTYPE html>
<?php
    require("../php/common.php");
    require("../php/checkLogin.php");
?>
<html>
<head>
    <title>Discovery | Breadbin</title>
    <link href="../css/common.css" rel="stylesheet" type="text/css">
    <link href="../css/navbar.css" rel="stylesheet" type="text/css">
    <link href="../css/discover.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/png" href="../img/favicon.png" />
    <script src="../js/vendor/jquery-1.11.2.min.js"></script>
    <script src="../js/vendor/jquery.cookie.js"></script>
    <script src="../js/vendor/jquery.wookmark.js"></script>
    <script src="../js/tileFunctions.js"></script>  
    <script>
        $(document).ready(function(){
            $('a.catLink').click(function(e){
                redirect = $(this).attr('href');
                e.preventDefault(); 
                $('#content').fadeOut(400, function(){
                    document.location.href = redirect
                });
            });

            $('#mainLoader').hide();
            $("#content").animate({ opacity: 1}, 1000); 
            $('#content').css("pointer-events", "auto");
        });
    </script>
    
</head>
<body>
    <noscript>
      <META HTTP-EQUIV="Refresh" CONTENT="0;URL=error.php">
    </noscript>    
    
    <?php
    require('../php/template/navbar.php'); 
    ?>

    <div id="mainLoader">
        <i class="fa fa-spinner fa-pulse" style="font-size: 5em; pointer-events: none;"></i>
        <p>Loading some beautiful content...</p> 
    </div> 
        
    <div id="categories" style="background-color:#fff">
        <ul class="cats">

			<li class="cats">
                <a class="catLink" href="discover.php">All</a>
            </li>
            <li class="cats">
                <a class="catLink" href="staff-recom.php">Staff Recommendations</a>
            </li>
            <li class="cats">
                <a class="active">Top Posts</a>
            </li>
            <li class="cats">
                <a class="catLink" href="just-pictures.php">Just Pictures</a>
            </li>
            <li class="cats">
                <a class="catLink" href="just-text.php">Just Text</a>
            </li>
            
		</ul>
    </div>
        
    <div id="content">
        <div id="main">
            <?php
            $query        = "SELECT * FROM posts WHERE (toasts - burns) > 0 ORDER BY toasts DESC";
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
    </script>
</body>
</html>