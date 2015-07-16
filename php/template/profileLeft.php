<?php
    $id = $_SERVER['PHP_SELF'] == "profile.php" ? $_GET['id'] : $_SESSION['user']['id'];

    if (empty($_GET) && $_SERVER['PHP_SELF'] == "profile.php") {
        if ($_SESSION['user']['id']) {
            header('Location: profile.php?id=' . $_SESSION['user']['id']);
            die();
        }
    } else {

        $query        = "SELECT * FROM users WHERE id = :id";
        $query_params = array(':id' => $id);

        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
        $row    = $stmt->fetch();

        if ($row) {
            $userid    = $row['id'];
            $usersname = $row['username'];
            $email     = $row['email'];
            $firstname     = $row['firstname'];
            $lastname     = $row['lastname'];
            $rank = $row['rank'];

            if ($row['bio']) {
                $bio = $row['bio'];
            }

            if ($row['country']) {
                $country = $row['country'];
            }
        }

        $query        = "SELECT count(*) FROM following WHERE user_no = :id";
        $query_params = array(
            ':id' => $id
        );

        $result = $db->prepare($query);
        $result->execute($query_params);
        $noOfFollowers = $result->fetchColumn();

        $query        = "SELECT count(*) FROM following WHERE follower_id = :id";
        $query_params = array(
            ':id' => $id
        );

        $result = $db->prepare($query);
        $result->execute($query_params);
        $noOfFollowing = $result->fetchColumn();
    }
?>
<div id="leftProfile">
    <?php
        if (!file_exists('img/avatars/' . $id . '/avatar.jpg')) {
            echo '<div id="userAvatar"></div>';
        } else {
            echo '<div id="userAvatar" style="background: url(img/avatars/' . $id . '/avatar.jpg) no-repeat;"></div>';
        }

        if (isset($rank) && !empty($rank) && $rank != "user") { //Add a star
            echo '<div id="starOverlay"><i class="fa fa-star"></i></div>';
        }
    ?>

    <div class="userInfo">            
        <?php
        if (isset($usersname)) {
            if ($id == $_SESSION['user']['id']) { 
                echo '<div class="nameRow" style="padding-left:30px">' . $usersname;
                echo '<div id="avatarOverlay"><i class="fa fa-pencil"></i></div>'; 
            } else {
                echo '<div class="nameRow">' . $usersname;
            }
            echo '</div>';

            echo '<div class="locationRow">' . (isset($country) ? $country : "Earth") . '</div>';
            echo '<div class="bioRow">' . (isset($bio) ? $bio : "") . '</div>';
            echo '<div class="followerRow">';
            echo '<div class="followerLeft">';
            echo '<div class="followerTitle">Following</div>';
            echo '<div class="followerContent following">' . $noOfFollowing . '</div>';
            echo '</div>';
            echo '<div class="followerRight">';
            echo '<div class="followerTitle">Followers</div>';
            echo '<div class="followerContent followers">' . $noOfFollowers . '</div>';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div id="errormsg">User not found</div>';
        }
        ?>
    </div>
</div>

<div id="profileButtons">
    <?php
        if (isset($usersname)) {
            if (($id != $_SESSION['user']['id'])) {
    ?>
    <div class="bottomRow">
        <?php
            $query = "SELECT * FROM following WHERE follower_id = :id AND user_no = :userid";
            $query_params = array(
                ':id' => $_SESSION['user']['id'],
                ':userid' => $id
            );

            $stmt   = $db->prepare($query);
            $result = $stmt->execute($query_params);
            $row    = $stmt->fetch();
            if ($row['user_no'] != intval($id)) {
                echo '<button id="followBut" class="buttonstyle">Follow</button>';
            } else {
                echo '<button id="unFollowBut" class="buttonstyle">Unfollow</button>';
            }
        ?>
        <button id="messageBut" class="buttonstyle">Message</button>
        <button id="reportBut" class="buttonstyle">Report</button>
    </div>

    <?php
        } else {
    ?>
    <div class="bottomRow">
        <button class="saveBut buttonstyle" style="display: none;">Save</button>
    </div>

    <?php
        }
    }
    ?> 
</div>