<ul>
	<li><a href="index.php"><?=$LANG['HOME']?></a>
	<?php
	if ( $CURRENT_USER->getGroupId() == GROUP_ADMINISTRATOR ) {
	?>
		<li><a href="admin.php"><?=$LANG['ADMIN_SECTION']?></a>
	<?php
	}
	?>
	<br><br>
	<li><a href="<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_LOGOUT?>"><?=$LANG['LOGOUT']?></a>
</ul>