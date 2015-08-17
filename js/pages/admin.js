$(document).ready(function(){
    var data = {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
        series: [
            [5, 2, 4, 2, 0]
        ]
    };

    new Chartist.Line('.ct-chart', data); 
	
	$('#clearPosts').click(function(){
		createPopup('Clear Posts', 'Are you sure you want to clear ALL posts?', true, function() {
            $.ajax({
                type        : 'POST',
                url         : 'php/admin/clearPosts.php',
                dataType    : 'json',
                encode      : true,
                success:function(data) {
                    if (data.success) {
                        window.location.replace("admin.php");
                    } else {
                        createError(data.error);
                    } 
                }
            })
		})
	})
	
	$('#clearToasts').click(function(){
		createPopup('Clear Toasts', 'Are you sure you want to clear ALL toast ratings?', true, function() {
            $.ajax({
                type        : 'POST',
                url         : 'php/admin/clearToasts.php',
                dataType    : 'json',
                encode      : true,
                success:function(data) {
                    if (data.success) {
                        window.location.replace("admin.php");
                    } else {
                        createError(data.error);
                    } 
                }
            })
		})
	})
	
	$('#clearBurns').click(function(){
		createPopup('Clear Burns', 'Are you sure you want to clear ALL burn ratings?', true, function() {
            $.ajax({
                type        : 'POST',
                url         : 'php/admin/clearBurns.php',
                dataType    : 'json',
                encode      : true,
                success:function(data) {
                    if (data.success) {
                        window.location.replace("admin.php");
                    } else {
                        createError(data.error);
                    } 
                }
            })
		})
	})
	
	$('#clearFavourites').click(function(){
		createPopup('Clear Favourites', 'Are you sure you want to clear ALL staff favourites?', true, function() {
            $.ajax({
                type        : 'POST',
                url         : 'php/admin/clearFavourites.php',
                dataType    : 'json',
                encode      : true,
                success:function(data) {
                    if (data.success) {
                        window.location.replace("admin.php");
                    } else {
                        createError(data.error);
                    } 
                }
            })
		})
	})	
})