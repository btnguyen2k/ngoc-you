<center><h1><?=$LANG['ADMIN_TITLE']?></h1></center>
<center><h2><?=$LANG['ADMIN_TITLE_EDIT_CATEGORY']?></h2></center>
<?php $_FORM = $PAGE['form']; ?>
<?php $_CAT = $PAGE['category']; ?>
<?php
if ( $_CAT === NULL ) {
?>
	<center><span class="errorMessage"><?=$LANG['ERROR_CATEGORY_NOT_FOUND']?></span></center>
<?php
} else {
?>
	<form method="POST" action="<?=$_FORM['action']?>">
		<input name="<?=$_FORM['fieldCategoryId']?>" value="<?=$_FORM['valueCategoryId']+0?>" type="hidden">
		<table border="0" cellpadding="4" cellspacing="1" align="center">
		<tr>
			<td colspan="2" class="errorMessage" align="center"><?=$_FORM['errorMessage']?></td>
		</tr>
		<tr>
			<td><?=$LANG['CATEGORY_PARENT']?>:</td>
			<td>
				<select <?php if ( $_CAT->getNumChildren()>0 ) echo 'disabled="disabled"'; ?>
						name="<?=$_FORM['fieldCategoryParentId']?>">
					<option value="0">---</option>
					<?php
					foreach ( $PAGE['categoryTree'] as $cat ) {
						if ( $cat->getId() !== $_CAT->getId() ) {
					?>
							<option <?=$cat->getId()===$_FORM['valueParentCategoryId']?"selected":""?>
								value="<?=$cat->getId()?>"><?=htmlspecialchars($cat->getName())?></option>
					<?php
						}
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td><?=$LANG['CATEGORY_NAME']?>:</td>
			<td><input class="textbox_blue" name="<?=$_FORM['fieldCategoryName']?>" 
				value="<?=htmlspecialchars($_FORM['valueCategoryName'])?>" type="text" style="width: 256px"></td>
		</tr>
		<tr>
			<td><?=$LANG['CATEGORY_DESCRIPTION']?>:</td>
			<td>
				<textarea class="textbox_blue" name="<?=$_FORM['fieldCategoryDescription']?>"
					cols="4" style="width: 256px"><?=htmlspecialchars($_FORM['valueCategoryDescription'])?></textarea>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input style="width: 64px" class="button_default" type="submit" value="<?=$LANG['UPDATE']?>">
				<input onclick="location='<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_CAT_MANAGEMENT?>'" 
					style="width: 64px" class="button" type="button" value="<?=$LANG['CANCEL']?>">
			</td>
		</tr>
		</table>
	</form>
<?php
}
?>