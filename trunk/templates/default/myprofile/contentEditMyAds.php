<center><h1><?=$LANG['MY_PROFILE_TITLE']?></h1></center>
<center><h2><?=$LANG['MY_PROFILE_TITLE_EDIT_MY_ADS']?></h2></center>
<?php $_FORM = $PAGE['form']; ?>
<form method="POST" action="<?=$_FORM['action']?>">
	<table border="0" cellpadding="4" cellspacing="1" align="center">
	<?php
	if ( $_FORM['errorMessage'] != "" ) {
	?>
		<tr>
			<td colspan="2" class="errorMessage" align="center">
				<?=$_FORM['errorMessage']?>
			</td>
		</tr>
	<?php
	}
	?>			
	<tr>
		<td><?=$LANG['CATEGORY']?>:</td>
		<td>
			<select name="<?=$_FORM['fieldCategory']?>">
				<option value="0">&nbsp;</option>
				<?php
				foreach ( $PAGE['categoryTree'] as $cat ) {
					echo '<optgroup label="', htmlspecialchars($cat->getName()), '">';
					foreach ( $cat->getChildren() as $child ) {
						if ( $child->getId() == $PAGE['form']['valueCategory'] ) {
							echo '<option value="', $child->getId(), '" selected>';
						} else {
							echo '<option value="', $child->getId(), '">';
						}
						echo htmlspecialchars($child->getName()), '</option>';
					}
					echo '</optgroup>';
				}
				?>
			</select>
		</td>
	</tr>
	
	<tr>
		<td><?=$LANG['ADS_TITLE']?>:</td>
		<td><input class="textbox_blue" name="<?=$_FORM['fieldAdsTitle']?>" 
			value="<?=htmlspecialchars($_FORM['valueAdsTitle'])?>"
			type="text" style="width: 256px"></td>
	</tr>
	<tr>
		<td><?=$LANG['ADS_CONTENT']?>:</td>
		<td>
			<script type="text/javascript" src="<?=$_URI_TEMPLATE?>/fckeditor/fckeditor.js"></script>
			<script type="text/javascript" src="<?=$_URI_TEMPLATE?>/fckeditor/fckeditor.js"></script>
			<script type="text/javascript">
			var oFCKeditor = new FCKeditor('<?=$_FORM['fieldAdsContent']?>');
			oFCKeditor.BasePath	= '<?=$_URI_TEMPLATE?>/fckeditor/';
			oFCKeditor.Height	= 512;
			oFCKeditor.Value	= '<p>This is some <strong>sample text<\/strong>. You are using <a href="http://www.fckeditor.net/">FCKeditor<\/a>.<\/p>' ;
			oFCKeditor.Create();
			</script>
			<!--		
			<textarea class="textbox_blue" name="<?=$_FORM['fieldAdsContent']?>"
				id="<?=$_FORM['fieldAdsContent']?>" rows="25"
				style="width: 512px"><?=htmlspecialchars($_FORM['valueAdsContent']);?></textarea>
			<script type="text/javascript">
			xinha_editors = null;
			xinha_init    = null;
			xinha_config  = null;
			xinha_plugins = null;
			xinha_init = xinha_init ? xinha_init : function() {
				xinha_editors = xinha_editors ? xinha_editors :
					[
						//name of the textarea(s) that shall be turned into Xinha(s).
						'<?=$_FORM['fieldAdsContent']?>'
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
			-->
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<input class="button_default" type="submit" value="<?=$LANG['POST_ADS']?>">
			<input onclick="location='<?=$_SERVER['PHP_SELF']?>'"
				style="width: 64px" class="button" type="button" value="<?=$LANG['CANCEL']?>">
		</td>
	</tr>
	</table>
</form>