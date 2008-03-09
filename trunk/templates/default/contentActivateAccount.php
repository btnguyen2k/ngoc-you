<center><h1><?=$LANG['ACTIVATE_ACCOUNT']?></h1></center>
<?php
    if ( isset($PAGE['errorMessage']) ) {
        echo '<span class="errorMessage">', $PAGE['errorMessage'], '</span>';
    } else {
        echo $PAGE['infoMessage'];
    }
?>