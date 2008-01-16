<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

define("FORM_FIELD_CURRENT_PASSWORD", "currentPassword");
define("FORM_FIELD_NEW_EMAIL", "newEmail");
define("FORM_FIELD_CONFIRMED_NEW_EMAIL", "confirmedNewEmail");

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - My Profile/Change Email';
$PAGE['form'] = Array();
$PAGE['form']['action'] = $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_CHANGE_EMAIL;
$PAGE['form']['fieldCurrentPassword'] = FORM_FIELD_CURRENT_PASSWORD;
$PAGE['form']['fieldNewEmail'] = FORM_FIELD_NEW_EMAIL;
$PAGE['form']['valueNewEmail'] = $CURRENT_USER->getEmail();
$PAGE['form']['fieldConfirmedNewEmail'] = FORM_FIELD_CONFIRMED_NEW_EMAIL;
$PAGE['form']['valueConfirmedNewEmail'] = $CURRENT_USER->getEmail();
$PAGE['form']['errorMessage'] = '';
$PAGE['form']['informationMessage'] = '';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$currentPwd = isset($_POST[FORM_FIELD_CURRENT_PASSWORD])
		? trim($_POST[FORM_FIELD_CURRENT_PASSWORD]) : "";
	$newEmail = isset($_POST[FORM_FIELD_NEW_EMAIL])
		? trim($_POST[FORM_FIELD_NEW_EMAIL]) : "";
	$confirmedNewEmail = isset($_POST[FORM_FIELD_CONFIRMED_NEW_EMAIL])
		? trim($_POST[FORM_FIELD_CONFIRMED_NEW_EMAIL]) : "";
	$PAGE['form']['valueNewEmail'] = $newEmail;
	$PAGE['form']['valueConfirmedNewEmail'] = $confirmedNewEmail;
	if ( !$CURRENT_USER->authenticate($currentPwd) ) {
		$PAGE['form']['errorMessage'] = $LANG['ERROR_PASSWORD_NOT_MATCH'];
	} elseif ( $newEmail == "" ) {
		$PAGE['form']['errorMessage'] = $LANG['ERROR_EMPTY_NEW_EMAIL'];
	} elseif ( $newEmail != $confirmedNewEmail ) {
		$PAGE['form']['errorMessage'] = $LANG['ERROR_CONFIRMED_EMAIL_NOT_MATCH'];
	} else {
		$oldEmail = trim($CURRENT_USER->getEmail());
		if ( strtolower($oldEmail) != strtolower($newEmail) ) {
			if ( getUserByEmail($newEmail) != NULL ) {
				$PAGE['form']['errorMessage'] = $LANG['ERROR_EMAIL_ALREADY_EXISTS'];
			}
		}
		if ( $PAGE['form']['errorMessage'] == '' ) {
			$CURRENT_USER->setEmail($newEmail);
			$PAGE['form']['informationMessage'] = $LANG['INFO_EMAIL_CHANGED'];
			updateUser($CURRENT_USER);	
		}		
	}
}
require_once 'templates/'.TEMPLATE.'/myprofile/pageChangeEmail.php';
?>