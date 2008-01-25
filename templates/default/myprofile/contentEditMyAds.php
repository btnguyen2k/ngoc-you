<center><h1><?=$LANG['MY_PROFILE_TITLE']?></h1></center>
<center><h2><?=$LANG['MY_PROFILE_TITLE_EDIT_MY_ADS']?></h2></center>
<?php $_FORM = $PAGE['form']; ?>
<form method="POST" action="<?=$_FORM['action']?>">
	<input type="hidden" name="html" value="0">
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
			<?php
			if ( WYSIWYG=='xinha' ) {
				require_once 'templates/'.TEMPLATE.'/xinha.php';
				xinha($_FORM['fieldAdsContent'], $_FORM['valueAdsContent'], 512, 300);
			} elseif ( WYSIWYG=='fckeditor' ) {
				require_once 'templates/'.TEMPLATE.'/fckeditor.php';
			} else {
				echo '<textarea class="textbox_blue" name="', $_FORM['fieldAdsContent'];
				echo '" id="', $_FORM['fieldAdsContent'], '" rows="25" style="width: 512px">';
				echo htmlspecialchars($_FORM['valueAdsContent']), '</textarea>';
			}
			?>			
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