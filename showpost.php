<?php
require("php/common.php");
require("php/checkLogin.php");

if (empty($_GET)) {
    if ($_SESSION['user']['id']) {
        header('Location: main.php');
        die();
    }
    
} ?>

<html>
<head>
    <title>Post <?php echo $_GET['p'] ?> | Breadbin</title>
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/jquery.cookie.js"></script>
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

                echo '<div id="contentPost" class="post-' . $row['id'] . '">';
                    echo '<div class="contentPostText">' . $row['text'] . '</div>';
                    echo '<div id="contentInfoText">';
                        echo '<div class="left"><a href="profile.php?id=' . $row['userid'] . '">' . $username . '</a></div>';
                        echo '<div class="right">' . timeAgoInWords($row['date']) . '</div>';
                    echo '</div>';
                echo '</div>';

                if ($_SESSION['user']['id'] == $row['userid']) { 
                    echo '<div id="contentLike" class="post-' . $row['id'] . '">
                        <p class="delete">Delete</p>';
                        echo '<p class="totalToasts">' .$totalToasts. '</p></div><br>';
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
                    echo '<p class="totalToasts">' .$totalToasts. '</p></div><br>';  
                }
            ?>
        </div>
        
    </div>

	<script src="js/formPost.js"></script>
</body>
</html>



<?php
} else {
    $query = "SELECT * FROM posts WHERE id = :id";
    $query_params = array(
        ':id' => intval($_GET['p'])
    );
    
    $stmt   = $db->prepare($query);
    $result = $stmt->execute($query_params);
    $row    = $stmt->fetch();
    
    if ($row) {
        $userid    = $row['id'];
        $usersname = $row['username'];
        $email     = $row['email'];
        
        if ($row['bio']) {
            $bio = $row['bio'];
        }
        
        if ($row['country']) {
            $country = $row['country'];
        }
    }
    
    $query        = "SELECT count(*) FROM following WHERE user_no = :id";
    $query_params = array(
        ':id' => intval($_GET['id'])
    );
    
    $result = $db->prepare($query);
    $result->execute($query_params);
    $noOfFollowers = $result->fetchColumn();
    
    $query        = "SELECT count(*) FROM following WHERE follower_id = :id";
    $query_params = array(
        ':id' => intval($_GET['id'])
    );
    
    $result = $db->prepare($query);
    $result->execute($query_params);
    $noOfFollowing = $result->fetchColumn();
}
?>
             
</body>
</html>