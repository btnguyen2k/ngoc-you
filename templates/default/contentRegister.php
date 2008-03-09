<center><h1><?=$LANG['REGISTER']?></h1></center>
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
	<tr>
		<td><?=$LANG['LOGIN_NAME']?>:</td>
		<td><input name="<?=$_FORM['fieldLoginName']?>" type="text" 
			value="<?=htmlspecialchars($_FORM['valueLoginName'])?>" style="width: 160px">
			*</td>
	</tr>
	<tr>
		<td><?=$LANG['PASSWORD']?>:</td>
		<td><input name="<?=$_FORM['fieldPassword']?>" type="password" style="width: 160px">
			*</td>
	</tr>
	<tr>
		<td><?=$LANG['CONFIRMED_PASSWORD']?>:</td>
		<td><input name="<?=$_FORM['fieldConfirmedPassword']?>" type="password" style="width: 160px">
			*</td>
	</tr>
	<tr>
		<td><?=$LANG['EMAIL']?>:</td>
		<td><input name="<?=$_FORM['fieldEmail']?>" type="text" 
			value="<?=htmlspecialchars($_FORM['valueEmail'])?>" style="width: 160px">
			*</td>
	</tr>
	<tr>
		<td><?=$LANG['FULL_NAME']?>:</td>
		<td><input name="<?=$_FORM['fieldFullName']?>" type="text" 
			value="<?=htmlspecialchars($_FORM['valueFullName'])?>" style="width: 160px">
			</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<input type="submit" value="<?=$LANG['REGISTER']?>">
			<input onclick='location.href="index.php"' type="button" value="<?=$LANG['CANCEL']?>">
		</td>
	</tr>
	</table>
</form>