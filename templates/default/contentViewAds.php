<?php
$_ADS = $PAGE['ads'];
$_CAT = $PAGE['category'];
$_ENTRIES = $PAGE['entries'];
if ( $_CAT == NULL ) {
	echo '<center><span class="errorMessage">', $LANG['ERROR_ADS_NOT_FOUND'], '</span></center>';
	return;
}
?>
<table border="0" cellpadding="4" width="100%" class="tblList">
<thead>
	<tr>
		<th align="left">
			<a href="<?=$_SERVER['PHP_SELF']?>"><?=APPLICATION_NAME?></a>
			>>
			<a href="<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_VIEW_CAT
			    .'&'.GET_PARAM_CATEGORY.'='.$_CAT->getId()?>"><?=htmlspecialchars($_CAT->getName())?></a>
			>>
			<?=htmlspecialchars($_ADS->getTitle())?>
		</th>
	</tr>
</thead>
<tbody>
	<tr>
		<td>
			<?=$_ADS->getContentForDisplay();?>
			<p style="font-style: italic" align="center"><?=$LANG['ADS_POST_DATE']?>:
				<b><?=date(DATE_FORMAT, $_ADS->getCreationTimestamp())?></b>
				-
				<?=$LANG['ADS_EXPIRY']?>:
				<b><?=date(DATE_FORMAT, $_ADS->getExpiryTimestamp())?></b>
			</p>
		</td>
	</tr>
</tbody>	
</table>