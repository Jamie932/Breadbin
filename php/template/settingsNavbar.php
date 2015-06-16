<script>
    function logout() {
        if (document.cookie.indexOf("hashkey") >= 0) {
            var confirmed = confirm("Are you sure you want to log out?");
      
            if (confirmed) {
                $.ajax({
                   type: "POST",
                   url: '../php/logout.php',
                   success:function(data) {
                       window.location.href = document.location.origin;
                   }
                });
            }
        }
    }
</script>

<div id="navbar">
	<div class="left">
		<a href="../main.php" class="navLinks">Bread Bin</a>
	</div>
	
	<div class="right">
		<ul class="nav">		
			<li class="nav">
                <?php
				    echo '<a class="navLinks" href="../profile.php?id=' . $_SESSION['user']['id'] . '">Profile</a>';
                ?>
			</li>
            
            <li class="nav"><a class="navLinks" href="#" onClick="logout(); return false;" >Logout</a></li>
		</ul>
	</div>
</div>