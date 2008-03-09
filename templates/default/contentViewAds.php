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
			<p style="font-style: italic">
    			<?php
    			if ( $CURRENT_USER !== NULL ) {
    			    $link = "index.php?".GET_PARAM_ACTION."=".ACTION_CONTACT_POSTER;
    			    $link .= "&".GET_PARAM_ADS."=".$_ADS->getId();
    			    echo $LANG['ADS_POST_BY'], ' <a href="', $link, '">';
    			    echo $_ADS->getPoster()->getLoginName();
    			    echo '</a>.';
    			} else {
    			    $link = "index.php?".GET_PARAM_ACTION."=".ACTION_LOGIN;
    			    $text = $LANG['ADS_LOGIN_TO_CONTACT_POSTER'];
    			    echo $LANG['ADS_POST_BY'], ' <a href="', $link, '">';
    			    echo $_ADS->getPoster()->getLoginName();
    			    echo '</a> (<a href="', $link, '">', $text, '</a>).';
    			}
    			?>
			    <?=$LANG['ADS_POST_DATE']?>:
				<b><?=date(DATE_FORMAT, $_ADS->getCreationTimestamp())?></b>
				-
				<?=$LANG['ADS_EXPIRY']?>:
				<b><?=date(DATE_FORMAT, $_ADS->getExpiryTimestamp())?></b>
			</p>
			<?=$_ADS->getContentForDisplay();?>
			<p>
			<?php
			$urlThumb = 'index.php?'.GET_PARAM_ACTION.'=thumbnail&id={0}&entry={1}';
			$urlImage = 'index.php?'.GET_PARAM_ACTION.'=viewAttachment&id={0}&entry={1}';
			foreach ( $ads->getAllAttachments() as $upload ) {
			    $urlT = str_replace('{0}', $upload->getId(), $urlThumb);
			    $urlT = str_replace('{1}', $upload->getEntryId(), $urlT);
			    $urlI = str_replace('{0}', $upload->getId(), $urlImage);
			    $urlI = str_replace('{1}', $upload->getEntryId(), $urlI);			    
			    echo '<a target="_blank" href="'.$urlI.'">';
			    echo '<img src="'.$urlT.'" border="1" width="60" vspace="4">';
			    echo '</a>&nbsp;';
			}
			?>
			</p>			
		</td>
	</tr>
</tbody>	
</table>