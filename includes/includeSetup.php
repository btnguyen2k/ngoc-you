<?php
require_once 'denyDirectInclude.php';
ini_set('short_open_tag', 1);

$includePath = '.';
$includePath .= PATH_SEPARATOR.'lib/adodb5-5.0.4';
ini_set("include_path", $includePath);
?>