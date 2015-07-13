<script>
    $(document).ready(function(){
        function createPopup(title, content) {
            if (title != undefined && content != undefined) {
                $('.popupTitle').text(title);
                $('.popupContent').text(content);
                $('#popup').fadeIn();
            } else {
                alert("Error making a popup");   
            }
        }
    })
</script>

<div id="popup">
    <div class="popupTitle"></div>
    <div class="popupContent"></div>
</div>