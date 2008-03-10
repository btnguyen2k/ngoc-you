<?php
include_once 'denyDirectInclude.php';
require_once 'class.phpmailer.php';

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
        $mail->FromName = $FromName;
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