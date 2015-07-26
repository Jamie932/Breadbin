function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');

    for (var i = 0; i < sURLVariables.length; i++) {   
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) {
            return sParameterName[1];
        }
    }
}

$(document).ready(function(){
	if (getUrlParameter('q')) {
		$('.searchBar').val(getUrlParameter('q'));
	}
	
	$(document).on('click','#errorClose', function() {
		clearErrors();
	})

	$(document).on('click','#searchIcon', function() {
		$('#searchForm').submit();
	})

     $('#searchForm').submit(function(event) {
		 if ($.trim($('.searchBar').val()).length) {
        	window.location.replace("/search.php?q=" + $('.searchBar').val());
		 }
		 
		 event.preventDefault();
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