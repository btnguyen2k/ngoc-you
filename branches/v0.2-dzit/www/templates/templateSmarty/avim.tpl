    <form name="frmHIM" method="GET" action="#">
    	<script language="javascript" type="text/javascript">
        {literal}
        	function changeVietnameseKeyboard(el) {
        		setMethod(el.options[el.selectedIndex].value);
        	}
        {/literal}
    	</script>
    	Vietnamese Keyboard:
    	<select onchange="changeVietnameseKeyboard(this);">
    		<option value="0">AUTO</option>
    		<option value="1">TELEX</option>
    		<option value="2">VNI</option>
    		<option value="3">VIQR</option>
    		<option value="-1">OFF</option>
    	</select>
    	<!--
    	<input id="him_auto" onclick="setMethod(0);" type="radio" name="viet_method">AUTO
    	<input id="him_telex" onclick="setMethod(1);" type="radio" name="viet_method">TELEX
    	<input id="him_vni" onclick="setMethod(2);" type="radio" name="viet_method">VNI
    	<input id="him_viqr" onclick="setMethod(3);" type="radio" name="viet_method">VIQR
    	<input id="him_viqr2" onclick="setMethod(4);" type="radio" name="viet_method">VIQR*
    	<input id="him_off" onclick="setMethod(-1);" type="radio" name="viet_method">OFF
    	-->
    </form>
