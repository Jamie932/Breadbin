<script src="../../js/errorHandler.js"></script>
<script src="../../js/pages/navbar.js"></script>

    <?php
        function isActive($pageName) {
            return basename($_SERVER['PHP_SELF']) == $pageName ? true : false;
        }

        $query = "SELECT * FROM user_settings WHERE user_id = :id"; 
        $query_params = array(':id' => $_SESSION['user']['id']); 

        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
        $row = $stmt->fetch();

        if($row){ 
            if ($row['colour'] == 2) {
                $colour = '#6699FF'; 
                $activecolour = '#4979D8';
                $lighterColour = '#69F';
            } else if ($row['colour'] == 3) {
                $colour = '#50B350';
                $activecolour = '#219921';
                $lighterColour = '#8AE68A';
            } else if ($row['colour'] == 4) {
                $colour = '#EC5858';
                $activecolour = '#DD2B2B';
                $lighterColour = '#F08181';
            } else if ($row['colour'] == 5) {
                $colour = '#8C68D8';
                $activecolour = '#7153B0';
                $lighterColour = '#AF98E0';
            } else if ($row['colour'] == 6) {
                $colour = '#CC7AB0';
                $activecolour = '#C2569E';
                $lighterColour = '#F6C';
			} else if ($row['colour'] == 7) { 
                $colour = '#363636';
                $activecolour = '#1A1A1A';
                $lighterColour = '#7B7B7B';
			} else {
                $colour = '#F6A628';
                $activecolour = '#D7870F'; 
                $lighterColour = '#FFB540';
            }
        }

        echo '<div id="navbar" class="noselect" style="background-color:' .$colour .'" >'
    ?>

	<div class="left">
		<a href="/main.php" id="navTitle" class="navLinks" style="float: left;"><img src="/img/logoSmall.png" style="vertical-align: middle; margin-bottom: 5px;"></img></a>
         
		<div id="searchContainer">
			<form id="searchForm">
				<div id="searchIcon" <?php echo 'style="background-color:' . $activecolour . '">';?><i class="fa fa-search"></i></div>
				<input type="text" placeholder="Search..." class="searchBar" <?php echo 'style="background-color:' . $activecolour . '">';?>
			</form>
		</div>
	</div>

	<div class="right">
		<ul class="nav">
            <?php 
                if (!empty($_SESSION['user']['rank']) && ($_SESSION['user']['rank'] != "user")) { 
                    if (isActive("admin.php")) {
                        echo '<li class="nav activePage" style="background-color: ' . $activecolour . '">';
                    } else {
                        echo '<li class="nav">';
                    }
                    
                    echo '<a class="navLinks" href="/admin.php">Admin</a></li>';
                }

                if (isActive("discover.php")) {
                    echo '<li class="nav activePage" style="background-color: ' . $activecolour . '">';
                } else {
                    echo '<li class="nav">';
                }
            ?>
                <a class="navLinks" href="/discover.php">Discover</a>
            </li>
        
            <?php
                if ((isActive("profile.php") && (isset($_GET['id']) && $_GET['id'] == $_SESSION['user']['id'])) || isActive("settings.php")) {
                    echo '<li class="nav activePage" style="background-color: ' . $activecolour . '">';
                } else {
                    echo '<li class="nav">';
                }

                echo '<a class="navLinks" href="/profile.php?id=' . $_SESSION['user']['id'] . '">' . $_SESSION['user']['username'] . '</a>';
                echo '<div class="arrow-up"></div>';
            ?>
        
                <ul >
                    <li><a class="navLinks" href="/toasted.php">Toasted</a></li>
                    <li><a class="navLinks" href="/burned.php">Burned</a></li>
                    <li><a class="navLinks" href="/settings.php">Settings</a></li>
                    <li><a class="navLinks" href="#" onClick="createPopup('Logout', 'Are you sure you want to log out?', true, function() { logout(); }); return false;">Logout</a></li>
                </ul>
			</li>
            <!--<li class="nav"><a class="navLinks" href="#" onClick="logout(); return false;" >Logout</a></li>-->
		</ul>
	</div>

	<div id="loader">
		<i class="fa fa-spinner fa-pulse" style="font-size: 1em; pointer-events: none;"></i>
	</div>
</div> 

<div id="errorBar">
    <div id="errorText"></div>
    <div id="errorClose"><i class="fa fa-times" style="line-height: 35px"></i></div>
</div>
