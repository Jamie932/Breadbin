<?php
require("php/common.php");
require("php/checkLogin.php");
require("php/vendor/timeago.php");

if (empty($_GET)) {
    if ($_SESSION['user']['id']) {
        header('Location: main.php');
        die();
    }
} else {
    $query = "SELECT * FROM posts WHERE id=:id";
    $query_params = array(':id' => $_GET['p']); 

    $stmt = $db->prepare($query); 
    $result = $stmt->execute($query_params); 
    $row = $stmt->fetch();  
    
    if (!$row) {
        header('Location: main.php');
        die();
    }
}?>

<!DOCTYPE html>
<html>
<head>
    <title>Post <?php echo $_GET['p'] ?> | Breadbin</title>
    <link href="css/common.css" rel="stylesheet" type="text/css">
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href="css/vendor/normalize.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400' rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="js/vendor/jquery-1.11.2.min.js"></script>
    <script src="js/vendor/jquery.cookie.js"></script>
    <script src="js/postFunctions.js"></script>
    <style>
        body {
            height: auto;
            min-height: auto !important;
        }
        
        #content {
            height: auto;   
        }
    </style>
</head>
    
<body>
    <noscript>
      <META HTTP-EQUIV="Refresh" CONTENT="0;URL=error.php">
    </noscript>    
    
   <?php require('php/template/navbar.php');?>
    
    <div id="break"></div>
    
    <div id="center">
        <div id="content">
            <?php
                $query = "SELECT * FROM posts WHERE id=:id";
                $query_params = array(':id' => $_GET['p']); 

                $stmt = $db->prepare($query); 
                $result = $stmt->execute($query_params); 
                $row = $stmt->fetch();  

                $query = "SELECT * FROM users WHERE id=:id";
                $query_params = array(':id' => $row['userid']); 

                $stmt = $db->prepare($query); 
                $result = $stmt->execute($query_params); 
                $userrow = $stmt->fetch();

                $query = "SELECT * FROM post_burns WHERE postid = :postId AND userid = :userId"; 
                $query_params = array(':postId' => $row['id'], ':userId' => $_SESSION['user']['id']); 

                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params); 
                $ifBurnt = $stmt->rowCount();

                $query = "SELECT * FROM post_toasts WHERE postid = :postId AND userid = :userId"; 
                $query_params = array(':postId' => $row['id'], ':userId' => $_SESSION['user']['id']);
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params); 
                $ifToasted = $stmt->rowCount();

                $totalToasts = $row['toasts'] - $row['burns'];

                if (($row['type'] == 'image') || ($row['type'] == 'imagetext')) {

                    if (!file_exists($row['image'])) {
                        $query = "DELETE FROM posts WHERE id = :id"; 
                        $query_params = array(':id' => $row['id']); 

                        $stmt = $db->prepare($query); 
                        $result = $stmt->execute($query_params); 
                    }

                    list($width, $height) = getimagesize($row['image']);

                    if ($width > 600) {
                        $class = 'imgNoPadding';
                    } else {
                        $class = 'imgPadding';
                    }
                }

                if (($row['type'] == 'text') || ($row['type'] == 'imagetext')) {
                    if (preg_match_all('/(?<!\w)@(\w+)/', $row['text'], $matches)) {
                        $users = $matches[1];

                        foreach ($users as $user) {
                            $query = "SELECT id, username FROM users WHERE username = :username"; 
                            $query_params = array(':username' => $user); 

                            $stmt = $db->prepare($query); 
                            $result = $stmt->execute($query_params);
                            $userFound = $stmt->fetch(); 

                            if ($userFound) {
                                $row['text'] = str_replace('@' .$user, '<a href="profile.php?id=' .$userFound['id'] . '">' . $user . '</a>', $row['text']);
                            }

                        }
                    }
                }
                
                if ($row['type'] == "text") {
                    echo '<div id="contentPost" class="post-' . $row['id'] . '">';
                        echo '<div class="contentPostText">' . $row['text'] . '</div>';
                        echo '<div id="contentInfoText">';
                            echo '<div class="left"><a href="profile.php?id=' . $row['userid'] . '">' . $userrow['username'] . '</a></div>';
                            echo '<div class="right">' . timeAgoInWords($row['date']) . '</div>';
                        echo '</div>';
                    echo '</div>';
                    
                } else if ($row['type'] == "image") {
                   echo '<div id="contentPost" class="post-' . $row['id'] . '">';
                    echo '<div class="contentPostImage ' . $class . '"><img src="' . $row['image'] . '"></div>';
                         echo '<div id="contentInfoText">';
                            echo '<div class="left"><a href="profile.php?id=' . $row['userid'] . '">' . $userrow['username']  . '</a></div>';
                            echo '<div class="right">' . timeAgoInWords($row['date']) . '</div>';
                        echo '</div>';
                    echo '</div>';
                    
                } else if ($row['type'] == "imagetext") {
                    echo '<div id="contentPost" class="post-' . $row['id'] . '">';
                    echo '<div class="contentPostImage ' . $class . '"><img src="' . $row['image'] . '"><div class="imgtext">' . $row['text'] . '</div></div>';
                        echo '<div id="contentInfoText">';
                            echo '<div class="left"><a href="profile.php?id=' . $row['userid'] . '">' . $username . '</a></div>';
                            echo '<div class="right">' . timeAgoInWords($row['date']) . '</div>';
                        echo '</div>';
                    echo '</div>';
                }

                if ($_SESSION['user']['id'] == $row['userid']) { 
                    echo '<div id="contentLike" class="post-' . $row['id'] . '">
                        <p class="delete">Delete</p>';
                        echo '<p class="totalToasts">' .$totalToasts. '</p></div>';
                } else {
                    echo '<div id="contentLike" class="post-' . $row['id'] . '">';

                    if ($ifToasted == 0) {
                        echo '<p class="toast">Toast</p>';
                    } else {
                        echo '<p class="untoast">Toast</p>';
                    } 
                    if ($ifBurnt == 0) {
                        echo '<p class="burn">Burn</p>';
                    } else {
                        echo '<p class="unburn">Burn</p>';
                    }
                    echo '<p class="report">Report</p>';
                    echo '<p class="totalToasts">' .$totalToasts. '</p></div>';  
                }
            ?>
        </div>
        
    </div>
</body>
</html>