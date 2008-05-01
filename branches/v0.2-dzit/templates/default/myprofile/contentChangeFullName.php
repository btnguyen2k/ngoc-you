<center><h1><?=$LANG['MY_PROFILE_TITLE']?></h1></center>
<center><h2><?=$LANG['MY_PROFILE_TITLE_CHANGE_FULL_NAME']?></h2></center>
<?php $_FORM = $PAGE['form']; ?>
<form method="POST" action="<?=$_FORM['action']?>">
	<table border="0" cellpadding="4" cellspacing="1" align="center">
	<?php
	if ( $_FORM['errorMessage'] !== "" ) {
	?>
		<tr>
			<td colspan="2" class="errorMessage" align="center">
				<?=$_FORM['errorMessage']?>
			</td>
		</tr>
	<?php
	}
	?>			
	<?php
	if ( $_FORM['informationMessage'] !== "" ) {
	?>
		<tr>
			<td colspan="2" class="infoMessage" align="center">
				<?=$_FORM['informationMessage']?>
			</td>
		</tr>
	<?php
	}
	?>
	<tr>
		<td><?=$LANG['FULL_NAME']?>:</td>
		<td><?=htmlspecialchars($CURRENT_USER->getFullName())?></td>
	</tr>
	
	<tr>
		<td><?=$LANG['CURRENT_PASSWORD']?>:</td>
		<td><input class="textbox_blue" name="<?=$_FORM['fieldCurrentPassword']?>" 
			type="password" style="width: 256px"></td>
	</tr>
	<tr>
		<td><?=$LANG['NEW_FULL_NAME']?>:</td>
		<td><input class="textbox_blue" name="<?=$_FORM['fieldNewFullName']?>" 
			value="<?=htmlspecialchars($_FORM['valueNewFullName'])?>" type="text" style="width: 256px"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<input style="width: 64px" class="button_default" type="submit" value="<?=$LANG['UPDATE']?>">
			<input onclick="location='<?=$_SERVER['PHP_SELF']?>'"
				style="width: 64px" class="button" type="button" value="<?=$LANG['CANCEL']?>">
		</td>
	</tr>
	</table>
</form>