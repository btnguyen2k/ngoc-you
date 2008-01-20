<center><h1><?=$LANG['LOGIN']?></h1></center>
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
		<td><?= $LANG['LOGIN_NAME'] ?>:</td>
		<td><input name="<?= $_FORM['fieldLoginName'] ?>" type="text" style="width: 160px"></td>
	</tr>
	<tr>
		<td><?= $LANG['PASSWORD'] ?>:</td>
		<td><input name="<?= $_FORM['fieldPassword'] ?>" type="password" style="width: 160px"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<input type="submit" value="<?= $LANG['LOGIN'] ?>">
			<input onclick='location.href="index.php"' type="button" value="<?=$LANG['CANCEL']?>">
		</td>
	</tr>
	</table>
</form>