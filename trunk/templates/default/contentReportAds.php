<?php
$_ADS = $PAGE['ads'];
$_CAT = $PAGE['category'];
if ( $_ADS===NULL || $_CAT===NULL ) {
	echo '<center><span class="errorMessage">', $LANG['ERROR_ADS_NOT_FOUND'], '</span></center>';
	return;
}
?>
<table border="0" cellpadding="4" width="100%" class="tblList">
<thead>
	<tr>
   		<th align="left">
   		    <?=$LANG['ADS_REPORT_ADMIN']?>:
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
			<p align="center"><?=$LANG['ADS_REPORT_ADMIN_CONFIRMATION']?></p>
   			<?php $_FORM = $PAGE['form']; ?>
			<form method="POST" action="<?=$_FORM['action']?>">
				<input name="<?=$_FORM['fieldAdsId']?>" value="<?=$_FORM['valueAdsId']+0?>" type="hidden">
				<table border="0" cellpadding="4" align="center" class="tblForm">
				<tr>
					<td>&nbsp;</td>
					<td><img border="0" src="index.php?<?=GET_PARAM_ACTION?>=captcha&key=<?=$PAGE['captchaKey']?>"></td>
				</tr>
				<tr>
					<td><?=$LANG['SECURITY_CODE']?>:</td>
					<td><input name="<?=$_FORM['fieldCaptcha']?>" type="text" style="width: 160px"> *</td>
				</tr>
				<tr>
					<td align="center" colspan="2">
						<input class="button_default" style="width: 64px" type="submit" value="<?=$LANG['YES']?>">
						<input onclick="location='<?=$_SERVER['PHP_SELF'].'?'
						    .GET_PARAM_ACTION.'='.ACTION_VIEW_ADS.'&'
						    .GET_PARAM_ID.'='.$_ADS->getId()?>'"
							style="width: 64px" class="button" type="button" value="<?=$LANG['NO']?>">
					</td>
				</tr>
				</table>
			</form>
		</td>    		
   	</tr>
</tbody>	
</table>