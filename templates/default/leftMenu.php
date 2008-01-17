<ul>
	<li><a href="index.php"><?=$LANG['HOME']?></a>
	<?php
	if ( $CURRENT_USER != NULL ) {
	?>
		<li><a href="index.php"><?=$LANG['MY_PROFILE']?></a>
	<?php
	} else {
	?>
		<li><a href="<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_LOGIN?>"><?=$LANG['LOGIN']?></a>
	<?php
	}
	?>
</ul>