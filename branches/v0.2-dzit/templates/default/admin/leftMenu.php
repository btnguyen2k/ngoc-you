<ul>
	<li><a href="index.php"><?=$LANG['HOME']?></a>
	<li><a href="myprofile.php"><?=$LANG['MY_PROFILE']?></a>
	<li><a href="admin.php"><?=$LANG['ADMIN_SECTION']?></a>

	<br><br>

	<li><a href="<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_CAT_MANAGEMENT?>"><?=$LANG['ADMIN_CATEGORY_MANAGEMENT']?></a>
		<ul>
			<li><a href="<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_CREATE_CAT?>"><?=$LANG['ADMIN_CREATE_CATEGORY']?></a>
		</ul>
	
	<br>
	
	<li><a href="<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_LOGOUT?>"><?=$LANG['LOGOUT']?></a>
</ul>
<?php include 'templates/'.TEMPLATE.'/avim.php'; ?>