<center><h1><?=$LANG['MY_PROFILE_TITLE']?></h1></center>
<center><h2><?=$LANG['MY_PROFILE_TITLE_MY_ADS']?></h2></center>
<table cellpadding="4" cellspacing="1" align="center" width="75%" class="tblList">
<thead>
	<tr>
		<th width="50%" align="center">
			<?=$LANG['ADS_TITLE']?>
		</th>
		<th width="10%" class="contentCell_2" align="center">
			<?=$LANG['ADS_NUM_VIEWS']?>
		</th>
		<th width="20%" class="contentCell_2" align="center">
			<?=$LANG['ADS_EXPIRY']?>
		</th>
		<th width="20%" class="contentCell_2" align="center" colspan="2">
			<?=$LANG['ACTIONS']?>
		</th>
	</tr>
</thead>
<tbody>
	<?php
	if ( count($PAGE['myAds']) == 0 ) {
		echo '<tr><td colspan="5">', $LANG['NO_DATA_TO_DISPLAY'], '</td></tr>';
	} else {
		foreach ( $PAGE['myAds'] as $ads ) {
			echo '<tr><td><a target="_blank" href="index.php?', GET_PARAM_ACTION, '=viewAds&', GET_PARAM_ID;
			echo '=', $ads->getId(), '">', htmlspecialchars($ads->getTitle());
			echo '</a></td>';
			
			echo '<td align="center">', $ads->getNumViews(), '</td>';
			
			echo '<td align="center">', date(DATETIME_FORMAT, $ads->getExpiryTimestamp()), '</td>';
			
			$urlEdit = $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_EDIT_MY_ADS;
			$urlEdit .= '&'.GET_PARAM_ID.'='.$ads->getId();
			echo '<td align="center"><a href="', $urlEdit, '">', $LANG['EDIT'], '</a></td>';
			
			$urlDelete = $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_DELETE_MY_ADS;
			$urlDelete .= '&'.GET_PARAM_ID.'='.$ads->getId();
			echo '<td align="center"><a href="', $urlDelete, '">', $LANG['DELETE'], '</a></td>';
			
			echo '</tr>'; 
		}
	}
	?>
</tbody>
</table>
