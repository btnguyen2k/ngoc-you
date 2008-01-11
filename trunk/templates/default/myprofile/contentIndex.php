<center><h1><?=$LANG['MY_PROFILE_TITLE']?></h1></center>
<center><h2><?=$LANG['MY_PROFILE_TITLE_INDEX']?></h2></center>
<table cellpadding="4" cellspacing="1" align="center" width="75%">
<tr>
	<td width="40%" class="contentCell_2">
		<?=$LANG['USER_ID']?>
	</td>
	<td width="40%" class="contentCell_1" align="center">
		<?=$CURRENT_USER->getId()?>
	</td>
	<td width="20%" class="contentCell_1" align="center">
		&nbsp;
	</td>
</tr>
<tr>
	<td width="40%" class="contentCell_2">
		<?=$LANG['LOGIN_NAME']?>
	</td>
	<td width="40%" class="contentCell_1" align="center">
		<?=$CURRENT_USER->getLoginName()?>
	</td>
	<td width="20%" class="contentCell_1" align="center">
		&nbsp;
	</td>
</tr>
<tr>
	<td width="40%" class="contentCell_2">
		<?=$LANG['FULL_NAME']?>
	</td>
	<td width="40%" class="contentCell_1" align="center">
		<?=htmlentities($CURRENT_USER->getFullName())?>
	</td>
	<td width="20%" class="contentCell_1" align="center">
		<a href="<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_CHANGE_FULL_NAME?>"><?=$LANG['CHANGE']?></a>
	</td>
</tr>
<tr>
	<td width="40%" class="contentCell_2">
		<?=$LANG['EMAIL']?>
	</td>
	<td width="40%" class="contentCell_1" align="center">
		<?=htmlentities($CURRENT_USER->getEmail())?>
	</td>
	<td width="20%" class="contentCell_1" align="center">
		<a href="<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_CHANGE_EMAIL?>"><?=$LANG['CHANGE']?></a>
	</td>
</tr>
</table>