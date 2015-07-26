<?php
    require("common.php"); 
	require("vendor/timeago.php");
	
	if (!isset($_GET['q'])) {
        header('Location: main.php');
        die();
	}

    $query= "SELECT * FROM users WHERE username LIKE :query OR firstname LIKE :query OR lastname LIKE :query LIMIT 10";
    $query_params = array(':query' => '%' . $_GET['q'] . '%');
    $stmt = $db->prepare($query); 
    $result = $stmt->execute($query_params); 
	$users = $stmt->fetchAll();

    $query= "SELECT * FROM posts WHERE text LIKE '%:query%' LIMIT 10";
    $query_params = array(':query' => $_GET['q']);
    $stmt = $db->prepare($query); 
    $result = $stmt->execute($query_params); 
	$posts = $stmt->fetchAll();

    $query= "SELECT * FROM following WHERE follower_id = :userId"; 
    $query_params = array(':userId' => $_SESSION['user']['id']);
    $stmt = $db->prepare($query); 
    $result = $stmt->execute($query_params); 
	$following = $stmt->rowCount();

	if (count($users) == 0) {
		echo 'No results found using search term: ' . $_GET['q'];
		die();
	} 

	echo '<div id="usersBox">';
	echo '<div class="boxTitle"><b>3</b> Users Found <div class="expand"><i class="fa fa-angle-double-down"></i></div></div>';

	foreach ($users as $row) {	
			echo '<div class="user">';
				echo '<div class="userImage"></div>';
				echo '<div class="userInfo">';
					echo '<div class="userTitle">' . $row["username"] . '</div>';
					echo '<div class="userCountry">' . $row["country"] . '</div>';
					echo '<div class="userButtons"><input type="submit" value="Follow" class="buttonstyle"><input type="submit" value="Message" class="buttonstyle"></div>';
					echo '<div class="userBio">' . $row["bio"] . '</div>';
				echo '</div>';
			echo '</div>';
	}

	echo '</div>';
?>