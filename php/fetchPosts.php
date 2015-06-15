<?php
    require("common.php"); 
	require("timeago.php");
	
	$query = "SELECT * FROM posts ORDER BY date DESC"; 

	try{ 
		$stmt = $db->prepare($query); 
		$result = $stmt->execute(); 
	} 
	catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
	$posts = $stmt->fetchAll();
	
	foreach ($posts as $row) {
		$query = "SELECT * FROM users WHERE id = :id"; 
		$query_params = array(':id' => $row['userid']); 
	
        try{ 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 
		$userrow = $stmt->fetch();
		$username = 'Unknown';
				
		if($userrow){ 
			$username = $userrow['username'];
        } else {
            $query = "DELETE FROM posts WHERE userid = :userid"; 
            $query_params = array(':userid' => $row['userid']); 

            try{ 
                $stmt = $db->prepare($query); 
                $result = $stmt->execute($query_params); 
            } 
            catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 
        }
		
        if ($row['type'] == "image") {     
            echo '<div id="contentPost">';
            echo '<div class="contentPostImage"></div>';
                echo '<div class="contentPostInfo">';
                    echo '<div id="contentInfoText">';
                        echo '<div class="left"><a href="profile.php?id=' . $row['userid'] . '">' . $username . '</a></div>';
                        echo '<div class="right">' . timeAgoInWords($row['date']) . '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
            echo '<div id="contentLike"><P>Toast</P><P>Burn</P><P class="report">Report</P></div><br>';
            
        } else if ($row['type'] == "text") {
            echo '<div id="contentPost">';
                echo '<div class="contentPostText">' . $row['text'] . '</div>';
                echo '<div id="contentInfoText">';
                    echo '<div class="left"><a href="profile.php?id=' . $row['userid'] . '">' . $username . '</a></div>';
                    echo '<div class="right">' . timeAgoInWords($row['date']) . '</div>';
                echo '</div>';
            echo '</div>';
            echo '<div id="contentLike"><P>Toast</P><P>Burn</P><P class="report">Report</P></div><br>';
        }
	}
?>