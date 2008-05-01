<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

$id = isset($_GET['id']) ? $_GET['id']+0 : 0;
$entryId = isset($_GET['entry']) ? $_GET['entry']+0 : 0;
$ads = getEntry($entryId);
$upload = NULL;
if ( $ads !== NULL && $ads->isExpired() ) {
    $ads = NULL;
} else {
    $upload = $ads->getAttachment($id);
}
if ( $ads === NULL || $upload === NULL ) {
    header("HTTP/1.0 404 Not Found", true, 404);
} else {
    header('Content-Type: '.$upload->getMimeType());
    echo $upload->getFileContent();
}
?>