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
            encode      : true
        }) 

        .done(function(data) {
             console.log(data);

            if (!data.success) {
                // Already toasted the post - error.
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

                toastButton.css('color', 'darkgray'); 
                toastButton.toggleClass('toast untoast');
            };
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
            encode      : true
        })

        .done(function(data) {
             console.log(data); 

            if (!data.success) {
                // Already burnt the post - error.
                 createError("This post has already been burnt by you."); 
            } else {
                if (data.removedToast && data.addedBurn) { // Previously toasted
                    totalToasts.html(parseInt(totalToasts.text()) - 2);

                    toastButton.css('color', 'black'); 
                    toastButton.toggleClass('untoast toast');
                } else if (data.removedToast || data.addedBurn) {
                    totalToasts.html(parseInt(totalToasts.text()) - 1);
                } else {
                    createError("Incorrect burn data returned. Please inform an adminstrator."); 
                }

                burnButton.css('color', 'darkgray'); 
                burnButton.toggleClass('burn unburn');
            }
        })
    })

    $(".hide").click(function(){
        $("#contentLikeFollow").hide(500);
        $("#contentPostFollow").hide(500);
    });
	
    $(document).on('click','.fa-heart-o', function() {
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
			success:function(data) {
				if (!data.success) {
					createError(data.error);
				} 
			}
        });
			  
        $(this).addClass('fa-heart').removeClass('fa-heart-o');
    });

    $(document).on('click','.fa-heart', function() {
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
			success: function(data) {
				if (!data.success) {
					createError(data.error);
				}
			}
        })
			  
        $(this).addClass('fa-heart-o').removeClass('fa-heart');
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
				success:function(data) {
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