<center><h1><?=$LANG['MY_PROFILE_TITLE']?></h1></center>
<center><h2><?=$LANG['MY_PROFILE_TITLE_DELETE_MY_ADS']?></h2></center>
<?php $_FORM = $PAGE['form']; ?>
<?php $_ADS = $PAGE['ads']; ?>
<?php
if ( $_ADS === NULL ) {
?>
	<center><span class="errorMessage"><?=$LANG['ERROR_ADS_NOT_FOUND']?></span></center>
<?php
} else {
?>
	<form method="POST" action="<?=$_FORM['action']?>">
		<input name="<?=$_FORM['fieldAdsId']?>" value="<?=$_FORM['valueAdsId']+0?>" type="hidden">		
		<table border="0" cellpadding="4" cellspacing="1" align="center">
		<tr>
			<td colspan="2" class="errorMessage" align="center"><?=$LANG['CONFIRM_DELETE_ADS']?></td>
		</tr>
		<tr>
			<td><?=$LANG['CATEGORY']?>:</td>
			<td>
				<select disabled="disabled">
					<option value="0">&nbsp;</option>
					<?php
					foreach ( $PAGE['categoryTree'] as $cat ) {
						echo '<optgroup label="', htmlspecialchars($cat->getName()), '">';
						foreach ( $cat->getChildren() as $child ) {
							if ( $child->getId() === $_ADS->getCategoryId() ) {
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
			<td><input class="textbox_disabled" disabled="disabled" 
				value="<?=htmlspecialchars($_ADS->getTitle())?>" type="text" style="width: 256px"></td>
		</tr>
		<tr>
			<td><?=$LANG['ADS_CONTENT']?>:</td>
			<td>
				<textarea class="textbox_disabled" disabled="disabled"
					rows="10" style="width: 512px"><?=htmlspecialchars($_ADS->getContent())?></textarea>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input style="width: 64px" class="button_default" type="submit" value="<?=$LANG['YES']?>">
				<input onclick="location='<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_MY_ADS?>'" 
					style="width: 64px" class="button" type="button" value="<?=$LANG['NO']?>">
			</td>
		</tr>
		</table>
	</form>
<?php
}
?>