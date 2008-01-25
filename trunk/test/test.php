<form method="POST">
<textarea rows="25" cols="50" name="strInput"><?=isset($_POST['strInput'])?htmlspecialchars($_POST['strInput']):"";?></textarea>
<input type="submit">
</form>
<?php
function removeEvilHtmlTags($input) {
	$allowedTags = array(
		'<a>', '<p>', '<div>', '<blockquote>',
		'<b>', '<strong>', '<i>', '<em>', '<u>', '<strike>', '<del>',
	 	'<font>', '<h1>', '<h2>', '<h3>', '<h4>', '<h5>', '<h6>', '<h7>',
		'<sup>', '<sub>',
		'<ul>', '<ol>', '<li>',
		'<table>', '<thead>', '<th>', '<tbody>', '<tr>', '<td>',
	);
	$disabledAttrs = array('ok\w+');
	
	return preg_replace('/<(.*?)>/ie', 
		"'<' . preg_replace(array('/javascript:[^\"\']*/i', '/(" . implode('|', $disabledAttrs) . ")=[\"\'][^\"\']*[\"\']/i', '/\s+/'), array('', '', ' '), stripslashes('\\1')) . '>'", 
		strip_tags($input, implode('', $allowedTags)));
}

echo htmlspecialchars(removeEvilHtmlTags($_POST['strInput']));

?>