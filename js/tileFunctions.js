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

    var boxes = document.querySelectorAll(".box");

    for (i = 0; i < boxes.length; i++) {
      boxes[i].style.width = '300';
      boxes[i].style.height = '230';
      boxes[i].style.display = 'inline-table';
      boxes[i].style.margin = '0';
      boxes[i].style.textAlign = 'center';
      boxes[i].style.verticalAlign = 'middle';
      boxes[i].style.position = 'relative';
    }
    
    $("li").hover(function() {
        $(this).stop();
        $(this).find("#bottomImgTools").animate({"height":33},100);
        $(this).find(".postUsername").animate({"bottom":"3px"},100);
        $(this).find(".postLikeToast").animate({"bottom":"3px"},100);
    }, function() {
        $(this).stop();
        $(this).find("#bottomImgTools").animate({"height":0},100);
        $(this).find(".postUsername").animate({"bottom":"-25px"},100);
        $(this).find(".postLikeToast").animate({"bottom":"-25px"},100);
    });
    
});