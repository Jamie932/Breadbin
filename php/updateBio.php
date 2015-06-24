<?php
	header("Content-Type: application/json", true);
    require("common.php");

	$errors = array();
	$data = array();

    $query = "UPDATE users SET bio = :bio WHERE id = :userid AND bio != :bio"; 
    $query_params = array(':bio' => $_POST['content'], ':userid' => $_SESSION['user']['id']); 
    $stmt = $db->prepare($query);
    $result = $stmt->execute($query_params);
?> 