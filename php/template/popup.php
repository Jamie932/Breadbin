<script src="../../js/popupHandler.js"></script>

<div id="popup">
	<?php
		echo isset($colour) ? '<div class="popupTitle" style="background-color: '. $colour . '">' : '<div class="popupTitle">';
	?>
        <div id="leftTitle"></div>
        <div id="rightTitle"><i class="fa fa-times"></i></div>
    </div>
    <div id="popupContent"></div>
    <div id="popupBottomRow">
        <button class="popupOK buttonstyle" style="display: none;">OK</button>
        <button class="popupCancel buttonstyle" style="display: none;">Cancel</button>
    </div>
</div>