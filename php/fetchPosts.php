<?php
    require("common.php"); 
	
	function diff ($secondDate){
		$firstDateTimeStamp = $this->format("U");
		$secondDateTimeStamp = $secondDate->format("U");
		$rv = ($secondDateTimeStamp - $firstDateTimeStamp);
		$di = new DateInterval($rv);
		return $di;
	}	
	
	function time_elapsed_string($datetime, $full = false) {
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}	
	
	$query = "SELECT * FROM posts ORDER BY date DESC"; 

	try{ 
		$stmt = $db->prepare($query); 
		$result = $stmt->execute(); 
	} 
	catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
		}
		
		echo '<div id="contentPost">';
		echo '<div class="contentPostImage"></div>';
            echo '<div class="contentPostInfo">';
                echo '<div id="contentInfoText">';
                    echo '<div class="left">' . $username . '</div>';
                    echo '<div class="right">' . time_elapsed_string($row['date']) . '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
		
		echo '<div id="contentLike"><P>Toast</P><P>Burn</P><P class="report">Report</P></div><br>';
	}
?>