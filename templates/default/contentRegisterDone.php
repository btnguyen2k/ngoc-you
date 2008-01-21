<center><h1><?=$LANG['REGISTER']?></h1></center>
<?=str_replace('{0}', '<b>'.htmlspecialchars($PAGE['user']->getLoginName()).'</b>', $LANG['REGISTER_DONE'])?>