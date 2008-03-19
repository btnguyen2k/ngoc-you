<center><h1><?= $LANG['ADMIN_TITLE'] ?></h1></center>
<center><h2><?= $LANG['ADMIN_TITLE_INDEX'] ?></h2></center>
<table cellpadding="4" cellspacing="1" align="center" width="75%">
<tr>
	<td width="40%" class="contentCell_2">
		<!--  
		<a href="<?= $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_USER_MANAGEMENT ?>">
		-->
		<?= $LANG['ADMIN_NUMBER_OF_USERS'] ?>
		<!--  
		</a>
		-->
	</td>
	<td width="20%" class="contentCell_1" align="center"><b><?= $PAGE['content']['numUsers'] ?></b></td>
	<td width="40%" class="contentCell_1" align="center">&nbsp;</td>
</tr>
<tr>
	<td width="40%" class="contentCell_2"><?= $LANG['ADMIN_NUMBER_OF_CATEGORIES'] ?></td>
	<td width="20%" class="contentCell_1" align="center"><b><?= $PAGE['content']['numCategories'] ?></b></td>
	<td width="40%" class="contentCell_1" align="center">
		<a href="<?= $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_CAT_MANAGEMENT ?>">
		<?=$LANG['ADMIN_CATEGORY_MANAGEMENT']?>
		</a>
	</td>
</tr>
<tr>
	<td width="40%" class="contentCell_2"><?= $LANG['ADMIN_NUMBER_OF_ADS'] ?></td>
	<td width="20%" class="contentCell_1" align="center"><b><?= $PAGE['content']['numAds'] ?></b></td>
	<td width="40%" class="contentCell_1">&nbsp;</td>
</tr>
<tr>
	<td width="40%" class="contentCell_2"><?= $LANG['ADMIN_NUMBER_OF_EXPIRED_ADS'] ?></td>
	<td width="20%" class="contentCell_1" align="center"><b><?= $PAGE['content']['numExpiredAds'] ?></b></td>
	<td width="40%" class="contentCell_1" align="center">
		<a href="<?= $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_DELETE_EXPIRED_ADS ?>">
		<?=$LANG['ADMIN_DELETE_EXPIRED_ADS']?>
		</a>
	</td>
</tr>
<tr>
	<td width="40%" class="contentCell_2"><?= $LANG['ADMIN_NUMBER_OF_REPORTED_ADS'] ?></td>
	<td width="20%" class="contentCell_1" align="center"><b><?= $PAGE['content']['numReportedAds'] ?></b></td>
	<td width="40%" class="contentCell_1" align="center">
		<a href="<?= $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_VIEW_REPORTED_ADS ?>">
		<?=$LANG['ADMIN_VIEW_REPORTED_ADS']?>
		</a>
	</td>
</tr>
</table>