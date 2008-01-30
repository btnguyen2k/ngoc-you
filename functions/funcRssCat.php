<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

$id = isset($_GET[GET_PARAM_CATEGORY]) ? $_GET[GET_PARAM_CATEGORY]+0 : 0;
$cat = getCategory($id);
if ( $cat == NULL ) {
    echo $LANG['ERROR_CATEGORY_NOT_FOUND'];
} else {
    require_once 'lib/feedcreator.class.php';
    
    $urlSite = "http://".$_SERVER["HTTP_HOST"];
    $urlIndex = "http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];
    
    $rss = new UniversalFeedCreator();
    $rss->encoding = "UTF-8";
    $rss->title = htmlspecialchars(APPLICATION_NAME.' '.$cat->getName());
    $rss->description = htmlspecialchars($cat->getDescription());
    $rss->link = htmlspecialchars($urlIndex);
    $rss->syndicationURL = htmlspecialchars($urlSite.$_SERVER["REQUEST_URI"]);

    /*
     $image = new FeedImage();
     $image->title = APPLICATION_NAME." logo";
     $image->url = "logo url";
     $image->link = $rss->link;
     $image->description = "Site description";
     $rss->image = $image;
     */

    $entries = getEntriesForRss($cat->getId());
    
    foreach ( $entries as $entry ) {
        $item = new FeedItem();
        $item->title = htmlspecialchars($entry->getTitle());
        $item->link = $urlIndex.'?'.GET_PARAM_ACTION.'='.ACTION_VIEW_ADS;
        $item->link .= '&'.GET_PARAM_ID.'='.$entry->getId();
        $item->description = htmlspecialchars($entry->getTitle());
        $item->date = date(DATETIME_FORMAT, $entry->getCreationTimestamp());
        $item->source = $urlSite;
        $item->author = APPLICATION_NAME;

        $rss->addItem($item);
    }

    $rss->saveFeed("RSS1.0");
}
?>