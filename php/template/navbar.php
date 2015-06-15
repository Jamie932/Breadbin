<script>
    function logout() {
        if (isset($_COOKIE['hashkey'])) {
            $hash = $_COOKIE['hashkey'];
            
            alert($hash);
            $query = "DELETE FROM uniquelogs WHERE hash = :hash";
            $query_params = array(':hash' => $hash); 

            try{
                $stmt = $db->prepare($query); 
                $result = $stmt->execute($query_params); 
            }
            catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
            
            unset($hash);
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
            
            <li class="nav"><a class="navLinks" href="#" onClick="logout(); return false;" >Logout</a></li>
		</ul>
	</div>
</div>