<?php
require_once 'dao/dbUtils.php';
require_once 'includes/utils.php';
class You_Dzit_AttachmentThumbnailHandler extends You_Dzit_BaseActionHandler {
    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::performAction()}
     */
    protected function performAction() {
        $attachmentId = isset($_GET['id']) ? $_GET['id']+0 : 0;
        $adsId = isset($_GET['ads']) ? $_GET['ads']+0 : 0;
        $ads = getEntry($adsId);
        $upload = NULL;
        if ( $ads !== NULL && $ads->isExpired() ) {
            $ads = NULL;
        } else {
            $upload = $ads->getAttachment($attachmentId);
        }
        if ( $ads === NULL || $upload === NULL ) {
            header("HTTP/1.0 404 Not Found", true, 404);
        } else {
            $img = createThumbnail($upload->getMimeType(), $upload->getFileContent());
            if ( $img !== NULL ) {
                $mimeType = $upload->getMimeType();
                if ( $mimeType === 'image/jpg' || $mimeType === 'image/jpeg' ) {
                    header('Content-Type: image/jpeg');
                    imageJpeg($img);
                } elseif ( $mimeType === 'image/gif' ) {
                    header('Content-Type: image/gif');
                    imageGif($img);
                } elseif ( $mimeType === 'image/png' ) {
                    header('Content-Type: image/png');
                    imagePng($img);
                } else {
                    header('Content-Type: image/jpeg');
                    imageJpeg($img);
                }
                imageDestroy($img);
            } else {
                header('Content-Type: '.$upload->getMimeType());
                header('Content-Length: '.$upload->getFileSize());
                echo $upload->getFileContent();
            }
        }
        return NULL;
    }
}
?>
