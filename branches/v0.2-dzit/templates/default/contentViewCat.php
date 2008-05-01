<?php
$_CAT = $PAGE['category'];
$_ENTRIES = $PAGE['entries'];
if ( $_CAT === NULL ) {
    echo '<center><span class="errorMessage">', $LANG['ERROR_CATEGORY_NOT_FOUND'], '</span></center>';
    return;
}
?>
<table border="0" cellpadding="4" width="100%" class="tblList">
	<thead>
		<tr>
			<th align="left"><a href="<?=$_SERVER['PHP_SELF']?>"><?=APPLICATION_NAME?></a>
			>> <?=htmlspecialchars($_CAT->getName())?> <a
				href="<?=$PAGE['rss']?>"><img border="0" alt="RSS"
				src="<?='templates/'.TEMPLATE.'/images/rss.gif'?>"></a></th>
		</tr>
	</thead>
	<tbody>
	<?php
	if ( count($_ENTRIES) === 0 ) {
	    echo '<tr><td>', $LANG['NO_DATA_TO_DISPLAY'], '</td></tr>';
	} else {
	    $expiry = "";
	    foreach ( $_ENTRIES as $entry ) {
	        $tempExpiry = date('dmY', $entry->getExpiryTimestamp());
	        if ( $expiry !== $tempExpiry ) {
	            if ( $expiry !== "" ) {
	                echo '</td></tr>';
	            }
	            echo '<tr><td>';

	            //echo '<table border="0" cellpadding="4" cellspacing="0" class="tblSub" width="100%">';
	            //echo '<thead><tr><th>';
	            echo '<p>';
	            echo $LANG['ADS_POST_DATE'], ': ';
	            echo '<b>', date(DATE_FORMAT, $entry->getCreationTimestamp()), '</b>';
	            echo ' - ';
	            echo $LANG['ADS_EXPIRY'], ': ';
	            echo '<b>', date(DATE_FORMAT, $entry->getExpiryTimestamp()), '</b>';
	            echo '</p>';
	            //echo '</th></tr></thead>';
	            //echo '</table>';
	            $expiry = $tempExpiry;
	        }
	        $title = htmlspecialchars($entry->getTitle());
	        echo '<p>';
	        echo '- ';
	        echo '<a href="', $_SERVER['PHP_SELF'], '?', GET_PARAM_ACTION, '=', ACTION_VIEW_ADS;
	        echo '&', GET_PARAM_ID, '=', $entry->getId(), '">', $title, '</a>';
	        echo '<br>';
	        $urlThumb = 'index.php?'.GET_PARAM_ACTION.'=thumbnail&id={0}&entry={1}';
	        $urlImage = 'index.php?'.GET_PARAM_ACTION.'=viewAttachment&id={0}&entry={1}';
	        foreach ( $entry->getAllAttachments() as $upload ) {
	            $urlT = str_replace('{0}', $upload->getId(), $urlThumb);
	            $urlT = str_replace('{1}', $upload->getEntryId(), $urlT);
	            $urlI = str_replace('{0}', $upload->getId(), $urlImage);
	            $urlI = str_replace('{1}', $upload->getEntryId(), $urlI);
	            echo '<a target="_blank" href="'.$urlI.'">';
	            echo '<img src="'.$urlT.'" border="1" width="60" vspace="4">';
	            echo '</a>&nbsp;';
	        }
	        echo '</p>';
	    }
	    echo '</td></tr>';
	}
	?>
	</tbody>
</table>
