<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

if ( $CURRENT_USER == NULL ) {
    header("Location: index.php?".GET_PARAM_ACTION."=".ACTION_LOGIN);
    return;
}

define("FORM_FIELD_ADS_ID", "adsId");
define("FORM_FIELD_NAME", "name");
define("FORM_FIELD_EMAIL", "email");
define("FORM_FIELD_CONTENT", "content");

$id = 0;
if ( isset($_POST[FORM_FIELD_ADS_ID]) ) {
	$id = $_POST[FORM_FIELD_ADS_ID] + 0;
} elseif ( isset($_GET[GET_PARAM_ADS]) ) {
	$id = $_GET[GET_PARAM_ADS] + 0;
}
$ads = getEntry($id);
if ( $ads != NULL && $ads->isExpired() ) $ads = NULL;
$cat = $ads!=NULL ? getCategory($ads->getCategoryId()) : NULL;

$PAGE = Array();
$PAGE['pageTitle'] = APPLICATION_NAME.' - '.($ads!=NULL?htmlspecialchars($ads->getTitle()):"");
$PAGE['category'] = $cat;
$PAGE['ads'] = $ads;
$PAGE['form'] = Array();
$PAGE['form']['action'] = $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_CONTACT_POSTER;
$PAGE['form']['fieldAdsId'] = FORM_FIELD_ADS_ID;
$PAGE['form']['fieldName'] = FORM_FIELD_NAME;
$PAGE['form']['fieldEmail'] = FORM_FIELD_EMAIL;
$PAGE['form']['fieldContent'] = FORM_FIELD_CONTENT;
$PAGE['form']['valueAdsId'] = $id;
$PAGE['form']['valueName'] = $CURRENT_USER->getLoginName();
$PAGE['form']['valueEmail'] = $CURRENT_USER->getEmail();
$PAGE['form']['valueContent'] = '';
$PAGE['form']['errorMessage'] = '';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $name = isset($_POST[FORM_FIELD_NAME])
		? trim($_POST[FORM_FIELD_NAME]) : "";
	$email = isset($_POST[FORM_FIELD_EMAIL])
		? trim($_POST[FORM_FIELD_EMAIL]) : "";
	$content = isset($_POST[FORM_FIELD_CONTENT])
		? trim($_POST[FORM_FIELD_CONTENT]) : "";		
	$PAGE['form']['valueName'] = $name;
	$PAGE['form']['valueEmail'] = $email;
	$PAGE['form']['valueContent'] = $content;
	if ( $name == "" ) {
	    $PAGE['form']['errorMessage'] = $LANG['ERROR_EMPTY_ADS_CONTACT_POSTER_NAME'];
	} elseif ( $email == "" ) {
	    $PAGE['form']['errorMessage'] = $LANG['ERROR_EMPTY_ADS_CONTACT_POSTER_EMAIL'];
	} elseif ( $content == "" ) {
	    $PAGE['form']['errorMessage'] = $LANG['ERROR_EMPTY_ADS_CONTACT_POSTER_CONTENT'];
	} else {
	    $subject = $LANG['ADS_CONTACT_POSTER_EMAIL_SUBJECT'];
	    $body = $LANG['ADS_CONTACT_POSTER_EMAIL_BODY'];
	    $body = str_replace('{0}', '<b>'.htmlspecialchars($name).'</b>', $body);
	    $url = getSiteUrl().$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_VIEW_ADS
	        .'&'.GET_PARAM_ID.'='.$ads->getId();
	    $link = '<a href="'.$url.'">'.htmlspecialchars($ads->getTitle()).'</a>';	        
	    $body = str_replace('{1}', '<b>'.$link.'</b>', $body);
	    $body .= '<br><br>'.str_replace("\n", '<br>', htmlspecialchars($content));
	    sendEmail($email, $ads->getPoster()->getEmail(), $subject, $body);
	    $url = 'index.php?'.GET_PARAM_ACTION.'='.ACTION_CONTACT_POSTER_DONE
	        .'&'.GET_PARAM_ADS.'='.$ads->getId();
	    header('Location: '.$url);
	    return;
	}
	/*
	$cat = getCategory($categoryId);
	if ( $cat == NULL || $cat->getParentId()==0 ) {
		$PAGE['form']['errorMessage'] = $LANG['ERROR_INVALID_CATEGORY_SELECTION'];
	} elseif ( $adsTitle == "" ) {
		$PAGE['form']['errorMessage'] = $LANG['ERROR_EMPTY_ADS_TITLE'];
	} elseif ( $adsContent == "" ) {
		$PAGE['form']['errorMessage'] = $LANG['ERROR_EMPTY_ADS_CONTENT'];
	} else {
		if ( $html == 0 ) {
			$adsContent = str_replace("\n", "<br>", $adsContent);
		}
		$ads->setCategoryId($categoryId);
		$ads->setTitle($adsTitle);
		$ads->setContent(removeEvilHtmlTags($adsContent));
		updateEntry($ads);
		header('Location: myprofile.php?'.GET_PARAM_ACTION.'='.ACTION_MY_ADS);
		return;
	}
	*/
}

require_once 'templates/'.TEMPLATE.'/pageContactPoster.php';
?>