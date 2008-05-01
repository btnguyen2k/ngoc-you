<?php
require_once 'templates/'.TEMPLATE.'/header.php';
?>
<center><h1><?=$LANG['MY_PROFILE_TITLE']?></h1></center>
<center><h2><?=$LANG['MY_PROFILE_TITLE_LOGIN']?></h2></center>
<?php $_FORM = $PAGE['form']; ?>
<form method="POST" action="<?= $_FORM['action'] ?>">
	<table border="0" cellpadding="4" cellspacing="1" align="center">
	<tr>
		<td colspan="2" class="errorMessage"><?= $_FORM['errorMessage'] ?></td>
	</tr>
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
		<td><input type="submit" value="<?= $LANG['LOGIN'] ?>"></td>
	</tr>
	</table>
</form>
<?php
require_once 'templates/'.TEMPLATE.'/footer.php';
?>