<?php
include_once 'denyDirectInclude.php';

function removeEvilHtmlTags($input) {
	$allowedTags = array(
		'<a>', '<p>', '<div>', '<blockquote>',
		'<b>', '<strong>', '<i>', '<em>', '<u>', '<strike>', '<del>',
	 	'<font>', '<h1>', '<h2>', '<h3>', '<h4>', '<h5>', '<h6>', '<h7>',
		'<sup>', '<sub>',
		'<ul>', '<ol>', '<li>',
		'<table>', '<thead>', '<th>', '<tbody>', '<tr>', '<td>',
	);
	$disabledAttrs = array('on\\w+');
	
	return preg_replace('/<(.*?)>/ie', 
		"'<' . preg_replace(array('/javascript:[^\"\']*/i', '/(" . implode('|', $disabledAttrs) . ")=[\"\'][^\"\']*[\"\']/i', '/\s+/'), array('', '', ' '), stripslashes('\\1')) . '>'", 
		strip_tags($input, implode('', $allowedTags)));
}
?>