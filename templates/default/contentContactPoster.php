<?php
$_ADS = $PAGE['ads'];
$_CAT = $PAGE['category'];
if ( $_ADS==NULL || $_CAT==NULL ) {
	echo '<center><span class="errorMessage">', $LANG['ERROR_ADS_NOT_FOUND'], '</span></center>';
	return;
}
?>
<table border="0" cellpadding="4" width="100%" class="tblList">
<thead>
	<tr>
   		<th align="left">
   		    <?=$LANG['ADS_CONTACT_POSTER_OF']?>
   			<a href="<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_VIEW_CAT
   			    .'&'.GET_PARAM_CATEGORY.'='.$_CAT->getId()?>"><?=htmlspecialchars($_CAT->getName())?></a>
   			>>
   			<a href="<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_VIEW_ADS
   			    .'&'.GET_PARAM_ID.'='.$_ADS->getId()?>"><?=htmlspecialchars($_ADS->getTitle())?></a>
   		</th>
   	</tr>
</thead>
<tbody>
	<tr>
		<td>
   			<?php $_FORM = $PAGE['form']; ?>
			<form method="POST" action="<?=$_FORM['action']?>">
				<input name="<?=$_FORM['fieldAdsId']?>" value="<?=$_FORM['valueAdsId']+0?>" type="hidden">				
				<table border="0" cellpadding="4" align="center" class="tblForm">
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
					<td><?=$LANG['ADS_CONTACT_POSTER_NAME']?>:</td>
					<td><input class="textbox_blue" name="<?=$_FORM['fieldName']?>"
						value="<?=htmlspecialchars($_FORM['valueName'])?>"
						type="text" style="width: 256px"></td>
				</tr>
				<tr>
					<td><?=$LANG['ADS_CONTACT_POSTER_EMAIL']?>:</td>
					<td><input class="textbox_blue" name="<?=$_FORM['fieldEmail']?>"
						value="<?=htmlspecialchars($_FORM['valueEmail'])?>"
						type="text" style="width: 256px"></td>
				</tr>
				<tr>
					<td><?=$LANG['ADS_CONTACT_POSTER_CONTENT']?>:</td>
					<td><textarea class="textbox_blue" name="<?=$_FORM['fieldContent']?>"
						rows="10" style="width: 512px"
						><?=htmlspecialchars($_FORM['valueContent'])?></textarea></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input class="button_default" style="width: 64px" type="submit" value="<?=$LANG['OK']?>">
						<input onclick="location='<?=$_SERVER['PHP_SELF'].'?'
						    .GET_PARAM_ACTION.'='.ACTION_VIEW_ADS.'&'
						    .GET_PARAM_ID.'='.$_ADS->getId()?>'"
							style="width: 64px" class="button" type="button" value="<?=$LANG['CANCEL']?>">
					</td>
				</tr>
				</table>
			</form>
		</td>    		
   	</tr>
</tbody>	
</table>