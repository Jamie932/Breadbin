<script src="../../js/errorHandler.js"></script>
<script>
    $(document).ready(function(){
        $(document).on('click','#errorClose', function() {
            clearErrors();
        })
    });

    function logout() {
        if (document.cookie.indexOf("hashkey") >= 0) {
            var confirmed = confirm("Are you sure you want to log out?");
      
            if (confirmed) {
                $.ajax({
                   type: "POST",
                   url: '/php/logout.php',
                   success:function(data) {
                       window.location.href = document.location.origin;
                   }
                });
            }
        }
    }    
</script>

<?php
        $query = "SELECT * FROM user_settings WHERE user_id = :id"; 
        $query_params = array(':id' => $_SESSION['user']['id']); 
        
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
        $row = $stmt->fetch();

        if($row){ 
            if ($row['colour'] == 1) {
                $colour = '#8AE68A';
                $activecolour = '#44CB44';
            } else if ($row['colour'] == 2) {
                $colour = '#6699FF';
                $activecolour = '#4979D8';
            } else if ($row['colour'] == 3) {
                $colour = '#FFB540';
                $activecolour = '#F5A52B';
            } else if ($row['colour'] == 4) {
                $colour = '#FF66CC';
                $activecolour = '#CB479F';
            }
        }

        echo '<div id="navbar" class="noselect" style="background-color:' .$colour .'" >'
?>

	<div class="left">
		<a href="main.php" class="navLinks">Bread Bin</a>
	</div>
	
	<div class="right">
		<ul class="nav">
            <?php
                $filename = basename($_SERVER['PHP_SELF']);
            
                if ($filename == "discover.php") {
                    echo '<li class="nav" style="background-color: ' . $activecolour . '">';
                } else {
                    echo '<li class="nav">';
                }
            ?>
                <a class="navLinks" href="discover/discover.php">Discover</a>
            </li>
        
            <?php
                if (($filename == "profile.php" && (isset($_GET['id']) && $_GET['id'] == $_SESSION['user']['id'])) || $filename == "settings.php") {
                    echo '<li class="nav" style="background-color: ' . $activecolour . '">';
                } else {
                    echo '<li class="nav">';
                }

                echo '<a class="navLinks" href="profile.php?id=' . $_SESSION['user']['id'] . '">' . $_SESSION['user']['username'] . '</a>';
                echo '<div class="arrow-up"></div>';
            ?>
                <ul style="float: right;">
                    <li><a class="navLinks" href="settings.php">Settings</a></li>
                    <li><a class="navLinks" href="toasted.php">Toasted</a></li>
                    <li><a class="navLinks" href="#" onClick="logout(); return false;">Logout</a></li>
                </ul>
			</li>
            <!--<li class="nav"><a class="navLinks" href="#" onClick="logout(); return false;" >Logout</a></li>-->
		</ul>
	</div>
</div> 

<div id="errorBar">
    <div id="errorText"></div>
    <div id="errorClose"><i class="fa fa-times" style="line-height: 35px"></i></div>
</div>
