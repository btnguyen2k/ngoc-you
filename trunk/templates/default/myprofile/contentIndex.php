<center><h1><?=$LANG['MY_PROFILE_TITLE']?></h1></center>
<center><h2><?=$LANG['MY_PROFILE_TITLE_INDEX']?></h2></center>
<table cellpadding="4" cellspacing="1" align="center" width="75%">
<tr>
	<td width="40%" class="contentCell_2">
		<a href="<?= $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_USER_MANAGEMENT ?>">
		<?= $LANG['ADMIN_NUMBER_OF_USERS'] ?>
		</a>
	</td>
	<td width="10%" class="contentCell_1" align="center"><b><?= $PAGE['content']['numUsers'] ?></b></td>
	<td width="40%" class="contentCell_2">
		<a href="<?= $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_CAT_MANAGEMENT ?>">
		<?= $LANG['ADMIN_NUMBER_OF_CATEGORIES'] ?>
		</a>
	</td>
	<td width="10%" class="contentCell_1" align="center"><b><?= $PAGE['content']['numCategories'] ?></b></td>
</tr>
<tr>
	<td width="40%" class="contentCell_2"><?= $LANG['ADMIN_NUMBER_OF_ENTRIES'] ?></td>
	<td width="10%" class="contentCell_1" align="center"><b><?= $PAGE['content']['numEntries'] ?></b></td>
	<td width="40%" class="contentCell_2">&nbsp;</td>
	<td width="10%" class="contentCell_1" align="center">&nbsp;</td>
</tr>
</table>