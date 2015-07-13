<script>
    function createPopup(title, content) {
        if ((title && title != '') && (content && content != '')) {
            $('.popupTitle').text(title);
            $('.popupContent').text(content);
            $('#popup').fadeIn();
        } else {
            alert("Error making a popup");   
        }
    }
</script>

<div id="popup">
    <div class="popupTitle"></div>
    <div class="popupContent"></div>
</div>