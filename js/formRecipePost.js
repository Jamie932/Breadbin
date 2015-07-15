$(document).ready(function() {

    $('#postRecipeForm').submit(function(event) {
                    var formData = {
                        'title' : $('#recipeTitle').val(),
                        'ingredients' : $('#recipeIngredients').val(),
                        'instructions' : $('#recipeInstructions').val()
                    };

                    $.ajax({
                        type        : 'POST',
                        url         : 'php/postRecipe.php',
                        data        : formData,
                        dataType    : 'json',
                        encode      : true
                    })
                    
        event.preventDefault();
        
    })
});