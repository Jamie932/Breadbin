<script>
	$(document).ready(function(){
		$(window).scroll(function(){
			var y = $(window).scrollTop();
			if( y > 0 ){
				$("#navbar").css({'box-shadow':'none', '-moz-box-shadow':'none', '-webkit-box-shadow':'none'});
			} else {
				$("#navbar").css({'box-shadow':'inset 0 1px #fff, 0 1px 3px rgba(34,25,25,0.4);', 
					'-moz-box-shadow':'inset 0 1px #fff, 0 1px 3px rgba(34,25,25,0.4);', 
					'-webkit-box-shadow':'inset 0 1px #fff, 0 1px 3px rgba(34,25,25,0.4);'});
			}
		});
	})
</script>

<div id="navbar">
	<div class="left">
		<a href="main.php" class="navLinks">Bread Bin</a>
	</div>
	
	<div class="right">
		<ul class="nav">		
			<li class="nav">
				<a class="navLinks" href="settings.php" >Profile</a>
			</li>
		</ul>
	</div>
	
</div>