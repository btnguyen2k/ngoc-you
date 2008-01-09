<center><h1><?= $LANG['ADMIN_TITLE'] ?></h1></center>
<center><h2><?= $LANG['ADMIN_TITLE_CREATE_CATEGORY'] ?></h2></center>
<?php $_FORM = $PAGE['form']; ?>
<form method="POST" action="<?= $_FORM['action'] ?>">
	<table border="0" cellpadding="4" cellspacing="1" align="center">
	<tr>
		<td colspan="2" class="errorMessage" align="center"><?= $_FORM['errorMessage'] ?></td>
	</tr>
	<tr>
		<td><?= $LANG['CATEGORY_PARENT'] ?>:</td>
		<td>
			<select name="<?= $_FORM['fieldCategoryParentId'] ?>">
				<option value="0">---</option>
				<?php
				foreach ( $PAGE['categories'] as $cat ) {
				?>
					<option value="<?= $cat->getId() ?>"><?= htmlentities($cat->getName()) ?></option>
				<?php
				}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td><?= $LANG['CATEGORY_NAME'] ?>:</td>
		<td><input class="textbox_blue" name="<?= $_FORM['fieldCategoryName'] ?>" value="<?= htmlentities($_FORM['valueCategoryName']) ?>" type="text" style="width: 256px"></td>
	</tr>
	<tr>
		<td><?= $LANG['CATEGORY_DESCRIPTION'] ?>:</td>
		<td>
			<textarea class="textbox_blue" name="<?= $_FORM['fieldCategoryDescription'] ?>"
				cols="4" style="width: 256px"><?= htmlentities($_FORM['valueCategoryDescription']) ?></textarea>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<input style="width: 64px" class="button_default" type="submit" value="<?= $LANG['OK'] ?>">
			<input onclick="location='<?= $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_CAT_MANAGEMENT ?>'" style="width: 64px" class="button" type="button" value="<?= $LANG['CANCEL'] ?>">
		</td>
	</tr>
	</table>
</form>