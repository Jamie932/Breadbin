$(document).ready(function(){
	$(document).on('click','#errorClose', function() {
		clearErrors();
	})

	$(document).on('click','#searchIcon', function() {
		$('#searchForm').submit();
	})

     $('#searchForm').submit(function(event) {
		 if ($('.searchBar').value) {
        	window.location.replace("/search.php?q=" + $('.searchBar').value);
		 }
    });	
	
	$('.searchBar').keypress(function (e) {
	  if (e.which == 13) {
			$('#searchForm').submit();
			return false;
		}
	});
});

$(window).load(function() {
	$('#loader').hide();
});

function logout() {
	$.ajax({
	   type: "POST",
	   url: '/php/logout.php',
	   success:function(data) {
		   window.location.href = document.location.origin;
	   }
	});
}