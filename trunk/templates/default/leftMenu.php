<?php
if ( isset($CURRENT_USER) && $CURRENT_USER !== NULL ) {
	$name = htmlspecialchars($CURRENT_USER->getFullName());
	$name = '<b><a href="myprofile.php">' . $name . '</a></b>';
	echo str_replace('{0}', $name, $LANG['WELCOME']);
}
?>
<ul>
	<li><a href="index.php"><?=$LANG['HOME']?></a>
	<?php
	if ( isset($CURRENT_USER) && $CURRENT_USER !== NULL ) {
	?>
		<li><a href="myprofile.php"><?=$LANG['MY_PROFILE']?></a>
		<?php
		if ( isset($PAGE['category']) ) {
		?>
			<li><a href="<?='myprofile.php?'.GET_PARAM_ACTION.'=postAds&cat='.$PAGE['category']->getId()?>"><?=$LANG['POST_ADS']?></a>
		<?php
        } else {
		?>
			<li><a href="<?='myprofile.php?'.GET_PARAM_ACTION.'=postAds'?>"><?=$LANG['POST_ADS']?></a>
		<?php
        }
        ?>
		<li><a href="<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_LOGOUT?>"><?=$LANG['LOGOUT']?></a>
	<?php
		if ( $CURRENT_USER->getGroupId() === GROUP_ADMINISTRATOR ) {
			echo '<br><br>';
			echo '<li><a href="admin.php">', $LANG['ADMIN_SECTION'], '</a>';
		}
	} else {
	?>
		<li><a href="<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_LOGIN?>"><?=$LANG['LOGIN']?></a>
			/
			<a href="<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_REGISTER?>"><?=$LANG['REGISTER']?></a>
		<li><a href="<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_RESEND_ACTIVATION_CODE?>"><?=$LANG['RESEND_ACTIVATION_CODE']?></a>
	<?php
	}
	?>
</ul>
<?php include 'avim.php'; ?>