<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'includes/utils.php';
require_once 'dao/dbUtils.php';

define("FORM_FIELD_HTML", "html");
define("FORM_FIELD_CATEGORY", "category");
define("FORM_FIELD_ADS_LOCATION", "adsLocation");
define("FORM_FIELD_ADS_PRICE", "adsPrice");
define("FORM_FIELD_ADS_TYPE", "adsType");
define("FORM_FIELD_ADS_TITLE", "adsTitle");
define("FORM_FIELD_ADS_CONTENT", "adsContent");
define("FORM_FIELD_ATTACH_IMAGE", "attachImg");

$PAGE = Array();
$siteConfig = getAllConfigs();
$PAGE['config'] = $siteConfig;
$allLocations = getAllLocations();
$PAGE['locations'] = $allLocations;

$PAGE['pageTitle'] = APPLICATION_NAME.' - My Profile/Post to Classifieds';
$PAGE['categoryTree'] = getCategoryTree();
$PAGE['form'] = Array();
$PAGE['form']['action'] = $_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_POST_ADS;
$PAGE['form']['fieldCategory'] = FORM_FIELD_CATEGORY;
$PAGE['form']['fieldAdsLocation'] = FORM_FIELD_ADS_LOCATION;
$PAGE['form']['fieldAdsPrice'] = FORM_FIELD_ADS_PRICE;
$PAGE['form']['fieldAdsType'] = FORM_FIELD_ADS_TYPE;
$PAGE['form']['fieldAdsTitle'] = FORM_FIELD_ADS_TITLE;
$PAGE['form']['fieldAdsContent'] = FORM_FIELD_ADS_CONTENT;
$PAGE['form']['fieldAttachImage'] = FORM_FIELD_ATTACH_IMAGE;
$PAGE['form']['valueCategory'] = 0;
$PAGE['form']['valueAdsLocation'] = NULL;
$PAGE['form']['valueAdsPrice'] = NULL;
$PAGE['form']['valueAdsType'] = 0;
$PAGE['form']['valueAdsTitle'] = '';
$PAGE['form']['valueAdsContent'] = '';
$PAGE['form']['errorMessage'] = '';

if ( $_SERVER['REQUEST_METHOD'] !== 'POST' ) {
    $PAGE['form']['valueCategory'] = isset($_GET['cat']) ? $_GET['cat']+0 : 0;
} else {
    $categoryId = isset($_POST[FORM_FIELD_CATEGORY])
    ? $_POST[FORM_FIELD_CATEGORY]+0 : 0;
    $adsTitle = isset($_POST[FORM_FIELD_ADS_TITLE])
    ? trim($_POST[FORM_FIELD_ADS_TITLE]) : "";
    $adsContent = isset($_POST[FORM_FIELD_ADS_CONTENT])
    ? trim($_POST[FORM_FIELD_ADS_CONTENT]) : "";
    $html = isset($_POST[FORM_FIELD_HTML])
    ? $_POST[FORM_FIELD_HTML]+0 : 0;
    $adsLocation = isset($_POST[FORM_FIELD_ADS_LOCATION])?$_POST[FORM_FIELD_ADS_LOCATION]+0:0;
    $adsType = isset($_POST[FORM_FIELD_ADS_TYPE])?$_POST[FORM_FIELD_ADS_TYPE]+0:0;
    $adsPrice = NULL;
    if ( isset($_POST[FORM_FIELD_ADS_PRICE]) ) {
        if ( trim($_POST[FORM_FIELD_ADS_PRICE]) !== "" ) {
            $adsPrice = $_POST[FORM_FIELD_ADS_PRICE] + 0;
        }
    }

    $PAGE['form']['valueCategory'] = $categoryId;
    $PAGE['form']['valueAdsTitle'] = $adsTitle;
    $PAGE['form']['valueAdsContent'] = $adsContent;
    $PAGE['form']['valueAdsType'] = $adsType;
    $PAGE['form']['valueAdsPrice'] = $adsPrice;
    $PAGE['form']['valueAdsLocation'] = $adsLocation;

    $cat = getCategory($categoryId);
    $uploadFiles = Array();
    if ( $cat === NULL || $cat->getParentId()===0 ) {
        $PAGE['form']['errorMessage'] = $LANG['ERROR_INVALID_CATEGORY_SELECTION'];
    } elseif ( $adsTitle === "" ) {
        $PAGE['form']['errorMessage'] = $LANG['ERROR_EMPTY_ADS_TITLE'];
    } elseif ( $adsContent === "" ) {
        $PAGE['form']['errorMessage'] = $LANG['ERROR_EMPTY_ADS_CONTENT'];
    } else {
        if ( $siteConfig['MAX_UPLOAD_FILES'] > 0 && count($_FILES) > 0 ) {
            $totalSize = 0;
            $allowedFileTypes = preg_split('/[\s,;|]+/', strtolower(trim($siteConfig['ALLOWED_UPLOAD_FILE_TYPES'])));
            for ( $i = 0; $i < count($allowedFileTypes); $i++ ) {
                //normalize file types
                $allowedFileTypes[$i] = '.'.preg_replace('/^\.+/', '', $allowedFileTypes[$i]);
            }
            //check upload files
            for ( $i = 0; $i < $siteConfig['MAX_UPLOAD_FILES']; $i++ ) {
                $token = FORM_FIELD_ATTACH_IMAGE.$i;
                if ( !isset($_FILES[$token]) || $_FILES[$token]['error']===4 ) {
                    continue;
                }
                $fileName = strtolower($_FILES[$token]['name']);
                $allowed = false;
                foreach ( $allowedFileTypes as $type ) {
                    if ( substr($fileName, strlen($fileName)-strlen($type)) === $type ) {
                        $allowed = true;
                        break;
                    }
                }
                if  ( !$allowed ) {
                    $PAGE['form']['errorMessage'] = str_replace('{0}', $fileName, $LANG['ERROR_UPLOAD_FILE_NOT_ALLOWED']);
                    break;
                }

                if ( $_FILES[$token]['error']===3 ) {
                    $PAGE['form']['errorMessage'] = $LANG['ERROR_UPLOAD_GENERAL'];
                    break;
                }
                if ( $_FILES[$token]['error']===1 ) {
                    $PAGE['form']['errorMessage'] = $LANG['ERROR_UPLOAD_SIZE_TOO_LARGE_PHP_INI'];
                    break;
                }
                if ( $_FILES[$token]['error']===2 ) {
                    $PAGE['form']['errorMessage'] = $LANG['ERROR_UPLOAD_SIZE_TOO_LARGE_FORM'];
                    $PAGE['form']['errorMessage'] = str_replace('{0}', $_POST['MAX_FILE_SIZE']);
                    break;
                }

                $totalSize += $_FILES[$token]['size'];
                if ( $totalSize > $siteConfig['MAX_UPLOAD_SIZE'] ) {
                    $msg = $LANG['ERROR_UPLOAD_TOTAL_SIZE_TOO_LARGE'];
                    $msg = str_replace('{0}', $totalSize, $msg);
                    $msg = str_replace('{1}', $siteConfig['MAX_UPLOAD_SIZE'], $msg);
                    $PAGE['form']['errorMessage'] = $msg;
                    break;
                }

                $uploadFiles[] = $_FILES[$token];
            }
        }

        if ( $PAGE['form']['errorMessage'] === "" ) {
            //            if ( $html === 0 ) {
            //                $adsContent = str_replace("\n", "<br>", $adsContent);
            //            }
            $expiry = 7*24*3600; //expires in 7 days!
            $safeAdsContent = '';
            
            $params = Array(
                'category' => $cat,
                'user' => $CURRENT_USER,
                'expiry' => $expiry,
                'adsTitle' => $adsTitle,
            	'adsContent' => removeEvilHtmlTags($adsContent),
            	'adsType' => $adsType,
            	'adsPrice' => $adsPrice,
            	'adsLocation' => $adsLocation,
                'html' => $html
            );
            $newEntry = createEntry($params);
            addUploadFilesToEntry($newEntry, $uploadFiles);

            //notify watchers
            $emailSubject = $LANG['NEW_ADS_NOTIFY_EMAIL_SUBJECT'];
            $emailBody = $LANG['NEW_ADS_NOTIFY_EMAIL_BODY'];
            $emailBody = str_replace('{ADS_TITLE}', $adsTitle, $emailBody);
            $emailBody = str_replace('{CATEGORY_NAME}', $cat->getName(), $emailBody);
            $urlAds = getSiteUrl().'/index.php?'.GET_PARAM_ACTION.'=viewAds&id='.$newEntry->getId();
            $emailBody = str_replace('{URL_ADS}', $urlAds, $emailBody);
            $emailBody = str_replace('{EMAIL_ADMINISTRATOR}', $siteConfig['EMAIL_ADMINISTRATOR'], $emailBody);
            $watchers = getWatcherList($cat);
            foreach ( $watchers as $user ) {
                sendEmail($siteConfig['EMAIL_OUTGOING'], $user->getEmail(), $emailSubject, $emailBody, true);
            }
            header('Location: myprofile.php?'.GET_PARAM_ACTION.'='.ACTION_MY_ADS);
            return;
        }
    }
}

require_once 'templates/'.TEMPLATE.'/myprofile/pagePostAds.php';
?>