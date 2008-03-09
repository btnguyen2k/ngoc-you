<?php
$name = htmlspecialchars($CURRENT_USER->getFullName());
$name = '<b><a href="myprofile.php">' . $name . '</a></b>';
echo str_replace('{0}', $name, $LANG['WELCOME']);
?>
<ul>
	<li><a href="index.php"><?=$LANG['HOME']?></a>
	<?php
	if ( $CURRENT_USER->getGroupId() === GROUP_ADMINISTRATOR ) {
	?>
		<li><a href="admin.php"><?=$LANG['ADMIN_SECTION']?></a>
	<?php
	}
	?>
	
	<br><br>
	
	<li><?=$LANG['MY_PROFILE_MANAGEMENT']?>
		<ul>
			<li><a href="<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_CHANGE_EMAIL?>"><?=$LANG['MY_PROFILE_CHANGE_EMAIL']?></a>
			<li><a href="<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_CHANGE_FULL_NAME?>"><?=$LANG['MY_PROFILE_CHANGE_FULL_NAME']?></a>
			<li><a href="<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_CHANGE_PASSWORD?>"><?=$LANG['MY_PROFILE_CHANGE_PASSWORD']?></a>
		</ul>
	
	<br>
	
	<li><?=$LANG['ADS_MANAGEMENT']?>
		<ul>
			<li><a href="<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_MY_ADS?>"><?=$LANG['MY_ADS']?></a>
			<li><a href="<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_POST_ADS?>"><?=$LANG['POST_ADS']?></a>
		</ul>	
	
	<br>
		
	<li><a href="<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_LOGOUT?>"><?=$LANG['LOGOUT']?></a>
</ul>