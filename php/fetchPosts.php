<?php
    require("common.php"); 
	
	$query = "SELECT * FROM posts ORDER BY date DESC"; 

	try{ 
		$stmt = $db->prepare($query); 
		$result = $stmt->execute(); 
	} 
	catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		echo '<div id="contentPost">';
		echo '<div class="contentPostImage"></div>';
            echo '<div class="contentPostInfo">';
                echo '<div id="contentInfoText">';
                    echo '<div class="left">UsernameGoesHere</div>';
                    echo '<div class="right">' . $row['date'] . '</div>';
                echo '</div>;'
            echo '</div>';
        echo '</div>';
		
		echo '<div id="contentLike"><P>Toast</P><P>Burn</P><P class="report">Report</P></div><br>';
	}
?>