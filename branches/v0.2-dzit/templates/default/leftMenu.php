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
		    if ( isset($PAGE['isWatching']) && !$PAGE['isWatching'] ) {
		    ?>    
		    	<li><a href="<?='index.php?'.GET_PARAM_ACTION.'=watchCategory&cat='.$PAGE['category']->getId()?>"><?=$LANG['WATCH_CATEGORY']?></a>
		    <?php
		    } else if ( isset($PAGE['isWatching']) && $PAGE['isWatching'] ) {
		    ?>
		        <li><a href="<?='index.php?'.GET_PARAM_ACTION.'=unwatchCategory&cat='.$PAGE['category']->getId()?>"><?=$LANG['UNWATCH_CATEGORY']?></a>
		    <?php
		    }
		    ?>
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

<?php
if ( isset($PAGE['adsFilters']) ) {
    echo '<p align="center">', $LANG['ADS_FILTER'], '</p>';
    echo '<form>';
    echo '<table align="center" border="0" cellpadding="2" cellspacing="0">';
    
    echo '<tr>';
    echo '<td>', $LANG['ADS_LOCATION'], '</td>';
    echo '<td>';
    echo '<select name="">';
    echo '<option value="0">-----</option>';
    foreach ( $PAGE['locations'] as $key=>$value ) {
		if ( isset($_FORM['valueAdsLocation']) && $_FORM['valueAdsLocation']===$key ) {
			echo '<option selected value="'.($key+0).'">';
		} else {
			echo '<option value="'.($key+0).'">';
		}
		echo htmlspecialchars($value);
		echo '</option>';
	}
	echo '</select>';
    echo '</td>';
    echo '</tr>';
    
    echo '<td>', $LANG['ADS_TYPE'], '</td>';
    echo '<td>';
    echo '<select name="">';
    echo '<option value="-1">-----</option>';
    echo '<option value="0">', $LANG['ADS_TYPE_SELL'], '</option>';
    echo '<option value="1">', $LANG['ADS_TYPE_BUY'], '</option>';
	echo '</select>';
    echo '</td>';
    echo '</tr>';
    
    echo '<td>', $LANG['ADS_PRICE'], '</td>';
    echo '<td>';
    echo '<select name="">';
    echo '<option value="-1">-----</option>';
    echo '<option value="0">', $LANG['ADS_PRICE_CONTACT'], '</option>';
    echo '<option value="1">', $LANG['ADS_PRICE_FREE'], '</option>';
	echo '</select>';
    echo '</td>';
    echo '</tr>';
    
    echo '<tr><td>&nbsp;</td><td>';
    echo '<input class="button_default" type="button" value="', $LANG['UPDATE'], '">';
    echo '</td></tr>';
    
    echo '</table>';
    echo '</form>';
}
?>
<br>
<?php include 'avim.php'; ?>