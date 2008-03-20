<center>
<h1><?= $LANG['ADMIN_TITLE'] ?></h1>
</center>
<center>
<h2><?= $LANG['ADMIN_TITLE_PROCESS_REPORTED_ADS'] ?></h2>
</center>
<?php
$_ADS = $PAGE['reportedAds'];
if ( $_ADS===NULL ) {
	echo '<center><span class="errorMessage">', $LANG['ERROR_ADS_NOT_FOUND'], '</span></center>';
	return;
}
?>
<?php $_FORM = $PAGE['form']; ?>
<script language="javascript" type="text/javascript">
function processAds(form, processAction) {
	form.<?=$_FORM['fieldProcessAction']?>.value = processAction;
	form.submit();
}
</script>
<form action="<?=$_FORM['action']?>" method="POST">
	<input type="hidden" value="0" name="<?=$_FORM['fieldProcessAction']?>">
	<p align="center">
		<input type="button" value="<?=$LANG['DELETE']?>"
			onclick="processAds(this.form, 1);">
		<input type="button" value="<?=$LANG['ADS_REMOVE_REPORT_STATUS']?>"
			onclick="processAds(this.form, 2);">
		<input type="button" value="<?=$LANG['CANCEL']?>"
			onclick="location.href='admin.php?<?=GET_PARAM_ACTION.'='.ACTION_VIEW_REPORTED_ADS?>'">
	</p>
</form>
<table cellpadding="4" cellspacing="1" align="center" width="75%">
<tr>
	<td class="contentCell_2">
	    <?=$LANG['REPORTED_ADS']?>: <b><?=htmlspecialchars($_ADS->getEntry()->getTitle())?></b>
	    |
	    <?=$LANG['CATEGORY']?>: <b><?=htmlspecialchars($_ADS->getEntry()->getCategory()->getName())?></b>	    
	</td>
</tr>
<tr>
	<td class="contentCell_1">
		<?=$_ADS->getEntry()->getContent()?>
	</td>
</tr>
</table>
