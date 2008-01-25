<?php
function xinha($name, $value="", $width=512, $height=512) {
	global $_URI_TEMPLATE;
?>
	<script type="text/javascript">
		_editor_url  = "<?=$_URI_TEMPLATE?>/xinha/";	//include the trailing slash!
		_editor_lang = "en";
		_editor_skin = "silva";	
	</script>
<?php	
	echo '<script type="text/javascript" src="', $_URI_TEMPLATE, '/xinha/XinhaCore.js"></script>';
	echo '<textarea class="textbox_blue" name="', $name;
	echo '" id="', $name, '" style="width: ', $width, 'px; height: ', $height, 'px;">';
	echo htmlspecialchars($value), '</textarea>';
?>	
	<script type="text/javascript">
		xinha_editors = null;
		xinha_init    = null;
		xinha_config  = null;
		xinha_plugins = null;
		xinha_init = xinha_init ? xinha_init : function() {
			xinha_editors = xinha_editors ? xinha_editors :
				[
					//name of the textarea(s) that shall be turned into Xinha(s).
					'<?=$name?>'
				];
					
			xinha_plugins = xinha_plugins ? xinha_plugins :
				[
					//'CharacterMap',
					//'ContextMenu',
					//'ListType',
					//'Stylist',
					//'Linker',
					//'SuperClean',
					//'TableOperations'
				];
			// THIS BIT OF JAVASCRIPT LOADS THE PLUGINS, NO TOUCHING  :)
			if (!Xinha.loadPlugins(xinha_plugins, xinha_init)) return;
				
			xinha_config = xinha_config ? xinha_config() : new Xinha.Config();
			xinha_config.toolbar =
				[
					["popupeditor"],
					["separator","formatblock",/*"fontname",*/"fontsize","bold","italic","underline","strikethrough"],						
					["separator","forecolor",/*"hilitecolor",*/"textindicator"],
					//["separator","subscript","superscript"],
					["linebreak","separator","justifyleft","justifycenter","justifyright","justifyfull"],
					["separator","insertorderedlist","insertunorderedlist","outdent","indent"],
					["separator","inserthorizontalrule","createlink","insertimage","inserttable"],
					["linebreak","separator","undo","redo","selectall","print"], //(Xinha.is_gecko ? [] : ["cut","copy","paste","overwrite","saveas"]),
					["separator","killword","clearfonts","removeformat","toggleborders",/*"splitblock","lefttoright", "righttoleft"*/],
					["separator","htmlmode","showhelp","about"]
				];
			xinha_config.formatblock =
				{
					"&mdash; format &mdash;": "",
					"Normal"   : "p",
					"Heading 1": "h1",
					"Heading 2": "h2",
					"Heading 3": "h3",
					"Heading 4": "h4",
					"Heading 5": "h5",
					"Heading 6": "h6",						
				};
			xinha_config.fontsize =
				{
					"&mdash; size &mdash;": "",
					"1 (8 pt)" : "1",
					"2 (10 pt)": "2",
					"3 (12 pt)": "3",
					"4 (14 pt)": "4",
					"5 (18 pt)": "5",
					"6 (24 pt)": "6",
					"7 (36 pt)": "7"
				};
					
			xinha_editors = Xinha.makeEditors(xinha_editors, xinha_config, xinha_plugins);
				
			Xinha.startEditors(xinha_editors);
		}
		Xinha._addEvent(window, 'load', xinha_init);
	</script>	
<?php	
}
?>