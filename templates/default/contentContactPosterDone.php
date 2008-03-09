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
   			<p><?=$LANG['ADS_CONTACT_POSTER_DONE']?></p>
   			<p><a href="<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_VIEW_ADS
   			    .'&'.GET_PARAM_ID.'='.$_ADS->getId()?>"><?=$LANG['GO_BACK']?></a></p>
		</td>    		
   	</tr>
</tbody>	
</table>