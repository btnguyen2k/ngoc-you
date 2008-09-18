<?php
include_once 'denyDirectInclude.php';
require_once 'class.phpmailer.php';
require_once 'dao/dbUtils.php';

define('SEARH_QUERY_SPACE_CHARS', '\s,\.:!');

function processEmailContent($msg) {
    $app = Ddth_Dzit_ApplicationRegistry::getCurrentApplication();
    $urlCreator = $app->getUrlCreator();
    $site = '<a href="'.$urlCreator->getHomeUrl(true).'">'.getConfig(You_Dzit_Constants::CONFIG_SITE_NAME).'</a>';
    
    //$msg = str_replace("\n", "<br>", $msg);
    $msg = str_replace('{SITE}', $site, $msg);
    $msg = str_replace('{SITE_NAME}', getConfig(You_Dzit_Constants::CONFIG_SITE_NAME), $msg);
    $msg = str_replace('{SITE_TITLE}', getConfig(You_Dzit_Constants::CONFIG_SITE_TITLE), $msg);
    $msg = str_replace('{EMAIL_ADMINISTRATOR}', getConfig(You_Dzit_Constants::CONFIG_EMAIL_ADMINISTRATOR), $msg);
    $msg = str_replace('{URL_SITE}', $urlCreator->getHomeUrl(true), $msg);
    
    return $msg;
}

function tokenizeSearchQuery($queryStr) {
    $arr = preg_split('/[\s,]+/', trim(strip_tags($queryStr)));
    if ( $arr === NULL ) {
        $arr = Array();
    }
    $keywords = Array();
    $utf8 = Ddth_Vnvi_Utf8::getInstance();
    foreach ( $arr as $word ) {
        $word = preg_replace('/^['.SEARH_QUERY_SPACE_CHARS.']+/', '', $word);
        $word = preg_replace('/['.SEARH_QUERY_SPACE_CHARS.']+$/', '', $word);
        if ( strlen($word) < 2 ) {
            continue;
        }
        //$word = strtolower(md5(strtolower($word)));
        $word = strtolower(md5($utf8->toLower($word)));
        $keywords[$word] = $word;
    }
    return array_values($keywords);
}

function parseFileTypesString($str='') {
    $arr = preg_split('/[\s,;|]+/', strtolower(trim($str)));
    if ( $arr === NULL ) {
        $arr = Array();
    }
    $result = Array();
    foreach ( $arr as $fileType ) {
        $fileType = '.'.preg_replace('/^\.+/', '', $fileType);
        if ( !in_array($fileType, $result) ) {
            $result[] = $fileType;
        }
    }
    return $result;
}

function fileTypesToString($fileTypeArr=Array()) {
    return implode(' ', $fileTypeArr);
}

function createThumbnail($mimeType, $imageData) {
    $orgImg = NULL;
    $mimeType = strtolower($mimeType);
    $tmpfname = tempnam(NULL, NULL);
    if ( $tmpfname === false ) {
        return NULL;
    }
    
    $imgInfo = NULL;
    $tmpfile = fopen($tmpfname, 'wb');
    if ( $tmpfile === false ) {
        return NULL;
    }
    fwrite($tmpfile, $imageData);
    fclose($tmpfile);
    
    if ( $mimeType === 'image/jpg' || $mimeType === 'image/jpeg' ) {
        $orgImg = imagecreatefromjpeg($tmpfname);
    } elseif ( $mimeType === 'image/gif' ) {
        $orgImg = imagecreatefromgif($tmpfname);
    } elseif ( $mimeType === 'image/png' ) {
        $orgImg = imagecreatefrompng($tmpfname);
    }
    
    if ( $orgImg !== NULL ) {
        $imgInfo = getimagesize($tmpfname);
    }
    unlink($tmpfname);
    if ( $orgImg === NULL ) {
        return NULL;
    }
    if ( $imgInfo[0] < 60 || $imgInfo[1] < 1 ) {
        imagedestroy($orgImg);
        return NULL;
    }
    $newWidth = $imgInfo[0] <= 60 ? $imgInfo[0] : 60;
    $newHeight = $imgInfo[0] <= 60 ? $imgInfo[1] : $newWidth*$imgInfo[1]/$imgInfo[0];
    $newImg = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresized($newImg, $orgImg, 0, 0, 0, 0, $newWidth, $newHeight, $imgInfo[0], $imgInfo[1]);
    return $newImg;
}

function removeEvilHtmlTags($input) {
	$allowedTags = array(
		'<a>', '<p>', '<div>', '<blockquote>',
		'<b>', '<strong>', '<i>', '<em>', '<u>', '<strike>', '<del>',
	 	'<font>', '<h1>', '<h2>', '<h3>', '<h4>', '<h5>', '<h6>', '<h7>',
		'<sup>', '<sub>',
		'<ul>', '<ol>', '<li>',
		'<img>', '<br>',
		'<table>', '<thead>', '<th>', '<tbody>', '<tr>', '<td>',
	);
	$disabledAttrs = array('on\\w+');
	
	return preg_replace('/<(.*?)>/ie', 
		"'<' . preg_replace(array('/javascript:[^\"\']*/i', '/(" . implode('|', $disabledAttrs) . ")=[\"\'][^\"\']*[\"\']/i', '/\s+/'), array('', '', ' '), stripslashes('\\1')) . '>'", 
		strip_tags($input, implode('', $allowedTags)));
}

function sendEmail($from, $to, $subject, $body, $html=true, $extra=Array()) {
    $mail = new PHPMailer();
    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->Host = SMTP_SERVER;
    if ( defined("SMTP_PORT") ) {
        $mail->Port = SMTP_PORT;
    }
    $mail->CharSet = CHARSET;    
    $mail->From = $from;
    if ( isset($extra['fromName']) ) {
        $mail->FromName = $extra['fromName'];
    } else {
        $mail->FromName = $from;
    }
    $mail->Sender = $from; //return-path
    $mail->AddAddress($to);
    $mail->WordWrap = 50;    
    if ( $html ) {
        $mail->IsHTML(true);
        $subject = str_replace("\r\n", "\n", $subject);
        $subject = str_replace("\n", "<br>", $subject);        
    }
    $mail->Subject = $subject;
    $mail->Body = $body;    
    return $mail->Send();
}

function getSiteUrl() {
    $url = "";
    if ( strpos($_SERVER["SERVER_PROTOCOL"], 'HTTPS') !== false ) {
        $url = 'https://';
    } else {
        $url = 'http://';
    }
    $url .= $_SERVER["HTTP_HOST"];
    return $url;
}
?>