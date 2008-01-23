<center><h1><?=$LANG['MY_PROFILE_TITLE']?></h1></center>
<center><h2><?=$LANG['MY_PROFILE_TITLE_POST_ADS']?></h2></center>
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
			{CATEGORY}
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
			<textarea class="textbox_blue" name="<?=$_FORM['fieldAdsContent']?>"
				id="<?=$_FORM['fieldAdsContent']?>"
				style="width: 512px"><?=htmlspecialchars($_FORM['valueAdsTitle']);?></textarea></td>
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