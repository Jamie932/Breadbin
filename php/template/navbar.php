<script>
    function logout() {
        if (isset($_COOKIE['hashkey'])) {
            unset($_COOKIE['hashkey']);
            
            $query = "DELETE FROM uniquelogs WHERE hash = :hash"; 
            $query_params = array(':hash' => $_COOKIE['hashkey']); 

            try{ 
                $stmt = $db->prepare($query); 
                $result = $stmt->execute($query_params); 
            } 
            catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }   
            
            window.location.href = "index.php";
        }
    }
</script>

<div id="navbar">
	<div class="left">
		<a href="main.php" class="navLinks">Bread Bin</a>
	</div>
	
	<div class="right">
		<ul class="nav">		
			<li class="nav">
                <?php
				    echo '<a class="navLinks" href="profile.php?id=' . $_SESSION['user']['id'] . '">Profile</a>';
                ?>
			</li>
            
            <li class="nav"><a href="#" onClick="logout(); return false;">Logout</a></li>
		</ul>
	</div>
</div>