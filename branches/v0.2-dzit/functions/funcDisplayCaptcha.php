<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'includes/captcha.php';

$key = isset($_GET['key']) ? $_GET['key'] : "";
$image = captchaGetImage(96, 32, $key);
header('Content-Type: image/jpeg');
imageJpeg($image);
imageDestroy($image);
?>