$(document).ready(function () {
    var colors = ["#99B3FF", "#799979", "#1E1E1E", "#FF99FF", "#FFFFDB", "#FFB540"];
    
    var blocks = $("#top");
    for(var x = 0; x < blocks.length; x++){
        var random = Math.floor(Math.random() * colors.length);
        var selectedColor = colors[random];
        $(blocks[x]).css("background-color", selectedColor );
        colors.splice(random, 1);
    }
});