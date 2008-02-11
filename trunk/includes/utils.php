<?php
include_once 'denyDirectInclude.php';

function removeEvilHtmlTags($input) {
	$allowedTags = array(
		'<a>', '<p>', '<div>', '<blockquote>',
		'<b>', '<strong>', '<i>', '<em>', '<u>', '<strike>', '<del>',
	 	'<font>', '<h1>', '<h2>', '<h3>', '<h4>', '<h5>', '<h6>', '<h7>',
		'<sup>', '<sub>',
		'<ul>', '<ol>', '<li>',
		'<img>',
		'<table>', '<thead>', '<th>', '<tbody>', '<tr>', '<td>',
	);
	$disabledAttrs = array('on\\w+');
	
	return preg_replace('/<(.*?)>/ie', 
		"'<' . preg_replace(array('/javascript:[^\"\']*/i', '/(" . implode('|', $disabledAttrs) . ")=[\"\'][^\"\']*[\"\']/i', '/\s+/'), array('', '', ' '), stripslashes('\\1')) . '>'", 
		strip_tags($input, implode('', $allowedTags)));
}

function sendEmail($from, $to, $subject, $body) {
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $headers .= 'To: ' . $to . "\r\n";
    $headers .= 'From: ' . $from . "\r\n";

    //$log = "Sending email from $from to $to\nSubject: $subject\n$headers\nBody:\n$body";
    //error_log($log, 0);
    mail($to, $subject, $body, $headers);
}
?>