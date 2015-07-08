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
    
    <?php /*require('php/template/navbar.php');*/?>
    
    <div id="break"></div>
    
    <div id="main">
            <?php
                $query = "SELECT * FROM posts WHERE userid = :id ORDER BY date DESC";
                $query_params = array(
                    ':id' => 2
                );

                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
                $posts = $stmt->fetchAll();

                foreach ($posts as $row) {
                    if (($row['type'] == 'text') || ($row['type'] == 'imagetext')) {
                        if (preg_match_all('/(?<!\w)@(\w+)/', $row['text'], $matches)) {
                            $users = $matches[1];

                            foreach ($users as $user) {
                                $query = "SELECT id, username FROM users WHERE username = :username";
                                $query_params = array(
                                    ':username' => $user
                                );

                                $stmt = $db->prepare($query);
                                $result = $stmt->execute($query_params);
                                $userFound = $stmt->fetch();

                                if ($userFound) {
                                    $row['text'] = str_replace('@' . $user, '<a href="profile.php?id=' . $userFound['id'] . '">' . $userFound['username'] . '</a>', $row['text']);
                                }

                            }
                        }
                    }

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
        ?>
               
               </ul>
            </div>
        
</body>
</html>