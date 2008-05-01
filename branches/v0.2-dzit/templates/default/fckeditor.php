<?php
function fckeditor($name, $value="", $width=512, $height=512) {
    global $_URI_TEMPLATE;
?>
	<input type="hidden" id="<?=$name.'_temp'?>" name="<?=$name.'_temp'?>" value="<?=htmlspecialchars($value);?>">
	<script type="text/javascript" src="<?=$_URI_TEMPLATE?>/fckeditor/fckeditor.js"></script>
	<script type="text/javascript">	
	var oFCKeditor			= new FCKeditor('<?=$name?>');	
	oFCKeditor.BasePath		= '<?=$_URI_TEMPLATE?>/fckeditor/';
	oFCKeditor.Config["CustomConfigurationsPath"]
							= "<?=$_URI_TEMPLATE?>/myfckconfig.js"  ;
	oFCKeditor.Height		= <?=$height?>;
	oFCKeditor.Width		= <?=$width?>;
	oFCKeditor.Value		= document.forms[0].<?=$name.'_temp'?>.value;
	oFCKeditor.ToolbarSet	= 'MyFCKToolbar' ;
	oFCKeditor.Create();
	</script>
<?php
}
?>