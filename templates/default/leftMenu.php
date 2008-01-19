<?php
if ( isset($CURRENT_USER) && $CURRENT_USER != NULL ) {
	$name = htmlspecialchars($CURRENT_USER->getFullName());
	$name = '<b><a href="myprofile.php">' . $name . '</a></b>';
	echo str_replace('{0}', $name, $LANG['WELCOME']);
}
?>
<ul>
	<li><a href="index.php"><?=$LANG['HOME']?></a>
	<?php
	if ( isset($CURRENT_USER) && $CURRENT_USER != NULL ) {
	?>
		<li><a href="myprofile.php"><?=$LANG['MY_PROFILE']?></a>
		<li><a href="<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_LOGOUT?>"><?=$LANG['LOGOUT']?></a>
	<?php
	} else {
	?>
		<li><a href="<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_LOGIN?>"><?=$LANG['LOGIN']?></a>
	<?php
	}
	?>
</ul>