<center><h1><?=$LANG['ADMIN_TITLE']?></h1></center>
<center><h2><?=$LANG['ADMIN_TITLE_DELETE_CATEGORY']?></h2></center>
<?php $_FORM = $PAGE['form']; ?>
<?php $_CAT = $PAGE['category']; ?>
<?php
if ( $_CAT == NULL ) {
?>
	<center><span class="errorMessage"><?=$LANG['ERROR_CATEGORY_NOT_FOUND']?></span></center>
<?php
} elseif ( $_CAT->getNumChildren() > 0 ) {
?>
	<center><span class="errorMessage"><?=$LANG['ERROR_CATEGORY_HAS_CHILDREN']?></span></center>
<?php
} else {
?>
	<form method="POST" action="<?=$_FORM['action']?>">
		<input name="<?=$_FORM['fieldCategoryId']?>" value="<?=$_FORM['valueCategoryId']+0?>" type="hidden">		
		<table border="0" cellpadding="4" cellspacing="1" align="center">
		<tr>
			<td colspan="2" class="errorMessage" align="center"><?=$LANG['CONFIRM_DELETE_CATEGORY']?></td>
		</tr>
		<tr>
			<td><?=$LANG['CATEGORY_NAME']?>:</td>
			<td><input class="textbox_disabled" disabled="disabled" value="<?=htmlspecialchars($_CAT->getName())?>" type="text" style="width: 256px"></td>
		</tr>
		<tr>
			<td><?=$LANG['CATEGORY_DESCRIPTION']?>:</td>
			<td>
				<textarea class="textbox_disabled" disabled="disabled"
					cols="4" style="width: 256px"><?=htmlspecialchars($_CAT->getDescription())?></textarea>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input style="width: 64px" class="button_default" type="submit" value="<?=$LANG['YES']?>">
				<input onclick="location='<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_CAT_MANAGEMENT?>'" 
					style="width: 64px" class="button" type="button" value="<?=$LANG['NO']?>">
			</td>
		</tr>
		</table>
	</form>
<?php
}
?>