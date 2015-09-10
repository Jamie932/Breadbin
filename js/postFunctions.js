$(document).ready(function(){
    $(document).on('click','.delete', function() {
		var postid = $(this).parent().attr('class').split('-')[1];

		var formData = {
			'post' : postid
		};		
		
        createPopup('Delete', 'Are you sure you want to delete this post?', true, 	function() {
            $.ajax({
                type        : 'POST',
                url         : 'php/deletePost.php',
                data        : formData,
                dataType    : 'json',
                encode      : true,
                success:function(data) {
                    if (data.success) {
                        window.location.replace("main.php");
                        //$('.post-' + postid).animate({height: 0, opacity: 0, marginBottom: 0}, 600, function() { $(this).remove();});

                    } else {
                        createError(data.error);
                    } 
                }
            })
        });
    })

    $(document).on('click','.toast', function() {
        var postid = $(this).parent().attr('class').split('-')[1]; 
        var totalToasts = $(this).closest('#contentLike').children('.totalToasts');
        var toastButton = $(this).closest('#contentLike').children('.toast');
        var burnButton = $(this).closest('#contentLike').children('.unburn');

        var formData = {
            'post' : postid
        };
 
        $.ajax({
            type        : 'POST',
            url         : 'php/toast.php',
            data        : formData,
            dataType    : 'json',
            encode      : true,
			error		: function(request, status, error) { console.log(request.responseText); },
			success		: function(data) {
				if (!data.success) {
					createError("This post has already been toasted by you."); 
				} else {
					if (data.removedBurn && data.addedToast) { // Previously toasted
						totalToasts.html(parseInt(totalToasts.text()) + 2);

						burnButton.css('color', 'black'); 
						burnButton.toggleClass('unburn burn');
					} else if (data.removedBurn || data.addedToast) {
						totalToasts.html(parseInt(totalToasts.text()) + 1);
					} else {
						createError("Incorrect toast data returned. Please inform an adminstrator."); 
					}

					toastButton.css('-webkit-filter', 'grayscale'); 
					toastButton.css('filter', 'grayscale(100%)'); 
					toastButton.toggleClass('toast untoast');
				};
			}
        })
    })
    
    $(document).on('click','.toastDisc', function() {
        var postid = $(this).parent().attr('id').split('-')[1]; 
        var toastButton = $(this).closest('.postLikeToast').children('.toastDisc');
        var burnButton = $(this).closest('.postLikeToast').children('.unBurnDisc');

        var formData = {
            'post' : postid
        };
 
        $.ajax({
            type        : 'POST',
            url         : 'php/toast.php',
            data        : formData,
            dataType    : 'json',
            encode      : true,
			error		: function(request, status, error) { console.log(request.responseText); },
			success		: function(data) {
				if (!data.success) {
					createError("This post has already been toasted by you."); 
				} else {
					if (data.removedBurn && data.addedToast) { // Previously toasted
						burnButton.css('color', 'white'); 
                        burnButton.toggleClass('unBurnDisc burnDisc');
					} else {
						createError("Incorrect toast data returned. Please inform an adminstrator."); 
					}
                    
                    toastButton.css('color', 'orange');  
                    toastButton.toggleClass('toastDisc unToastDisc');
				};
			}
        })
    })
    
    $(document).on('click','.burnDisc', function() {
        var postid = $(this).parent().attr('id').split('-')[1]; 
        var toastButton = $(this).closest('.postLikeToast').children('.unToastDisc');
        var burnButton = $(this).closest('.postLikeToast').children('.burnDisc');

        var formData = {
            'post' : postid
        };

        $.ajax({
            type        : 'POST',
            url         : 'php/burn.php',
            data        : formData,
            dataType    : 'json',
            encode      : true,
			error		: function(request, status, error) { console.log(request.responseText); },
			success		: function(data) {
				if (!data.success) {
                 	createError("This post has already been burnt by you."); 
				} else {
					if (data.removedToast && data.addedBurn) { // Previously toasted
						toastButton.css('color', 'white'); 
                        toastButton.toggleClass('toastDisc unToastDisc');
					} else {
						createError("Incorrect burn data returned. Please inform an adminstrator."); 
					}

					burnButton.css('color', 'orange');
                    burnButton.toggleClass('unBurnDisc burnDisc');
				};
			}
        })
    })

    $(document).on('click','.burn', function() {
        var postid = $(this).parent().attr('class').split('-')[1];
        var totalToasts = $(this).closest('#contentLike').children('.totalToasts');
        var burnButton = $(this).closest('#contentLike').children('.burn');
        var toastButton = $(this).closest('#contentLike').children('.untoast');

        var formData = {
            'post' : postid
        };

        $.ajax({
            type        : 'POST',
            url         : 'php/burn.php',
            data        : formData,
            dataType    : 'json',
            encode      : true,
			error		: function(request, status, error) { console.log(request.responseText); },
			success		: function(data) {
				if (!data.success) {
                 	createError("This post has already been burnt by you."); 
				} else {
					if (data.removedToast && data.addedBurn) { // Previously toasted
						totalToasts.html(parseInt(totalToasts.text()) - 2);

						toastButton.css('-webkit-filter', 'none'); 
					    toastButton.css('filter', 'grayscale(0%)'); 
						toastButton.toggleClass('untoast toast');
					} else if (data.removedToast || data.addedBurn) {
						totalToasts.html(parseInt(totalToasts.text()) - 1);
					} else {
						createError("Incorrect burn data returned. Please inform an adminstrator."); 
					}

					burnButton.css('color', 'darkgray'); 
					burnButton.toggleClass('burn unburn');
				};
			}
        })
    })
	
    $(document).on('click','#heartMiniRed', function() {
		var postid = $(this).parent().attr('class').split('-')[1];
		var formData = {
			'post' : postid
		};

        $.ajax({
            type        : 'POST',
            url         : 'php/admin/favouritePost.php',
            data        : formData,
            dataType    : 'json',
            encode      : true,
			error		: function(request, status, error) { console.log(request.responseText); },
			success		: function(data) {
				if (!data.success) {
					createError(data.error);
				} 
			}
        });
			  
        $('.fa-heart-o').addClass('fa-heart').removeClass('fa-heart-o');
    });

    $(document).on('click','#heartMiniNot', function() {
		var postid = $(this).parent().attr('class').split('-')[1];
		var formData = {
			'post' : postid
		};

        $.ajax({
            type        : 'POST',
            url         : 'php/admin/favouritePost.php',
            data        : formData,
            dataType    : 'json',
            encode      : true,
			error		: function(request, status, error) { console.log(request.responseText); },
			success		: function(data) {
				if (!data.success) {
					createError(data.error);
				}
			}
        })
			  
        $('.fa-heart').addClass('fa-heart-o').removeClass('fa-heart');
    });
	
    $(document).on('click','.fa-trash-o', function() {
		var postid = $(this).parent().attr('class').split('-')[1];
		var formData = {
			'post' : postid
		};
		
		createPopup('Delete', 'Are you sure you want to delete this post?', true, function() {
			$.ajax({
				type        : 'POST',
				url         : 'php/admin/deletePost.php',
				data        : formData,
				dataType    : 'json',
				encode      : true,
				error		: function(request, status, error) { console.log(request.responseText); },
				success		: function(data) {
					if (data.success) {
						window.location.replace("main.php");
					} else {
						createError(data.error);
					}
				}
			});
		});
    });
})