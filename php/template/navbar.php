<script>
    function logout() {
        if (document.cookie.indexOf("hashkey") >= 0) {
            alert("Hi");
            $.ajax({
               type: "POST",
               url: '/php/logout.php',
               success:function() {
                   window.location.href = "index.php";
               }
            });
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