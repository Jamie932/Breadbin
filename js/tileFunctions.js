$(window).load(function() {
    var options = {
        autoResize: true, // This will auto-update the layout when the browser window is resized.
        container: $('#main'), // Optional, used for some extra CSS styling
        offset: 5, // Optional, the distance between grid items
        itemWidth: 310 // Optional, the width of a grid item
    };
    
    var handler = $('#tiles li');
    handler.wookmark(options);
    
});

$(document).ready(function() {    
    var colors = [
        "rgb(138, 230, 138)",
        "rgb(102, 153, 255)",
        "rgb(255, 181, 64)",
        "rgb(255, 102, 204)"
    ];

    var boxes = document.querySelectorAll(".box");

    for (i = 0; i < boxes.length; i++) {
      boxes[i].style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
      boxes[i].style.width = '300';
      boxes[i].style.height = '230';
      boxes[i].style.display = 'inline-table';
      boxes[i].style.margin = '0';
      boxes[i].style.textAlign = 'center';
      boxes[i].style.verticalAlign = 'middle';
      boxes[i].style.position = 'relative';
    }
    
    $("#main li").hoverIntent( showBottom, hideBottom ); 
});

function showBottom(){
    $("#bottomImgTools").animate({"height":30},100);
    $(".postUsername").animate({"bottom":"3px"},100);
}
function hideBottom(){
    $("#bottomImgTools").animate({"height":0},100);
    $(".postUsername").animate({"bottom":"-20px"},100);
} 