<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

$id = isset($_GET[GET_PARAM_ID]) ? $_GET[GET_PARAM_ID]+0 : 0;
$activationCode = isset($_GET['activationCode']) ? trim($_GET['activationCode']) : NULL;
$user = getUser($id);

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - Account Activation'; 
$PAGE['user'] = $user;
if ( $user === NULL ) {
    $PAGE['errorMessage'] = $LANG['ERROR_USER_NOT_FOUND'];
} elseif ( !$user->isActivated() && $user->getActivationCode()!==$activationCode ) {
    $PAGE['errorMessage'] = $LANG['ERROR_ACTIVATION_CODE_NOT_MATCH'];
} else {
    if ( !$user->isActivated() ) {
        $user->setActivationCode(NULL);
        updateUser($user);
    }
    $PAGE['infoMessage'] = str_replace('{0}', $user->getLoginName(), $LANG['INFO_ACCOUNT_ACTIVATED']);
}

require_once 'templates/'.TEMPLATE.'/pageActivateAccount.php';
?>