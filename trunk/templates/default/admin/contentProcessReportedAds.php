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
<form action="<?=$_FORM['action']?>">
	<input type="hidden" value="0" name="<?=$_FORM['fieldProcessAction']?>">
	<center>
		<input type="button">
		<input type="button">
		<input type="button" value="<?=$LANG['CANCEL']?>">
	</center>
</form>
<table cellpadding="4" cellspacing="1" align="center" width="75%">
<tr>
	<td class="contentCell_2">
	    <?=$LANG['REPORTED_ADS']?>: <b><?=htmlspecialchars($_ADS->getEntry()->getTitle())?></b>
	    |
	    <b><?=htmlspecialchars($_ADS->getEntry()->getCategory()->getName())?></b>	    
	</td>
</tr>
<tr>
	<td class="contentCell_1">
		<?=$_ADS->getEntry()->getContent()?>
	</td>
</tr>
</table>
