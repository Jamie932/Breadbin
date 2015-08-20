<?php
    require("common.php"); 
	
	if (!isset($_GET['q'])) {
        header('Location: main.php');
        die();
	}

    $query= "SELECT * FROM users WHERE username LIKE :query OR firstname LIKE :query OR lastname LIKE :query LIMIT 10";
    $query_params = array(':query' => '%' . $_GET['q'] . '%');
    $stmt = $db->prepare($query); 
    $result = $stmt->execute($query_params); 
	$users = $stmt->fetchAll();
	$usersCount = $stmt->rowCount();

    $query= "SELECT * FROM posts WHERE text LIKE '%:query%' LIMIT 10";
    $query_params = array(':query' => $_GET['q']);
    $stmt = $db->prepare($query); 
    $result = $stmt->execute($query_params); 
	$posts = $stmt->fetchAll();

	echo '<div id="usersBox" class="box">';
	echo isset($colour) ? '<div class="boxTitle" style="background-color: '. $colour . '"><b>' . $usersCount . '</b> Users Found' : '<div class="boxTitle"><b>' . $usersCount . '</b> Users Found';
	echo '<div class="expand"> ' . $usersCount != 0 ? '<i class="fa fa-angle-double-down"></i>' : '<i class="fa fa-angle-double-down fa-rotate-negative-90"></i>' . '</div></div>';

	echo '<div id="usersRows">';
	foreach ($users as $row) {	
			echo '<div class="user">';
				echo file_exists('img/avatars/' . $row['id'] . '/avatar.jpg') ? '<div class="userImage" style="background-image: url(img/avatars/' . $row['id'] . '/avatar.jpg)"></div>' : '<div class="userImage"></div>';
				
				echo '<div class="userInfo">';
					echo '<div class="userTitle"><a href="profile.php?id=' . $row['id'] . '">' . $row['username'] . '</a></div>';
					echo '<div class="userCountry">' . $row["country"] . '</div>';
					echo '<div class="userButtons">';
		
                    $query = "SELECT * FROM following WHERE follower_id = :id AND user_no = :userid";
                    $query_params = array(
                        ':id' => $_SESSION['user']['id'],
                        ':userid' => $row['id']
                    );

                    $stmt = $db->prepare($query);
                    $result = $stmt->execute($query_params);
                    $following = $stmt->fetch();

					echo $following ? '<input type="submit" value="Unfollow" class="buttonstyle">' : '<input type="submit" value="Follow" class="buttonstyle">';
					echo '<input type="submit" value="Message" class="buttonstyle"></div>';
					echo '<div class="userBio">' . $row["bio"] . '</div>';
				echo '</div>';
			echo '</div>';
	}
	echo '</div>';
	echo '</div>';
?>