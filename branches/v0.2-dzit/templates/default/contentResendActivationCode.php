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
		<td><?=$LANG['EMAIL']?>:</td>
		<td><input name="<?=$_FORM['fieldEmail']?>" type="text" 
			value="<?=htmlspecialchars($_FORM['valueEmail'])?>" style="width: 160px">
			*</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><img border="0" src="index.php?<?=GET_PARAM_ACTION?>=captcha&key=<?=$PAGE['captchaKey']?>"></td>
	</tr>
	<tr>
		<td><?=$LANG['SECURITY_CODE']?>:</td>
		<td><input name="<?=$_FORM['fieldCaptcha']?>" type="text" style="width: 160px"> *</td>
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