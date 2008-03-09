<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

$id = isset($_GET[GET_PARAM_CATEGORY]) ? $_GET[GET_PARAM_CATEGORY]+0 : 0;
$cat = getCategory($id);
if ( $cat === NULL ) {
	echo $LANG['ERROR_CATEGORY_NOT_FOUND'];
} else {
	require_once 'lib/feedcreator.class.php';
	require_once 'lib/rss10.inc';

	$urlSite = "http://".$_SERVER["HTTP_HOST"];
	$urlIndex = "http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];

	$title = htmlspecialchars(APPLICATION_NAME.' '.$cat->getName());
	$desc = htmlspecialchars(APPLICATION_NAME.' '.$cat->getName());
	$rss = new RSSWriter($urlIndex, $title, $desc, Array("dc:publisher" => APPLICATION_NAME, "dc:creator" => APPLICATION_NAME));
	//$rss->setImage("Site Logo", APPLICATION_NAME." logo");
	$entries = getEntriesForRss($cat->getId());
	foreach ( $entries as $entry ) {
		$link = $urlIndex.'?'.GET_PARAM_ACTION.'='.ACTION_VIEW_ADS;
		$link .= '&'.GET_PARAM_ID.'='.$entry->getId();
		$title = htmlspecialchars($entry->getTitle());
		$desc = htmlspecialchars(strip_tags($entry->getContent()));
		$rss->addItem($link, $title, Array("description" => $desc, "dc:creator" => APPLICATION_NAME));
	}
	$rss->preamble();
	$rss->channelinfo();
	$rss->image();
	$rss->items();
	$rss->postamble();
	header("Content-type: application/xhtml+xml");
	//echo '<?xml version="1.0" encoding="UTF-8"';
	echo $rss->getxml();

	//    $rss = new UniversalFeedCreator();
	//    $rss->encoding = "UTF-8";
	//    $rss->title = htmlspecialchars(APPLICATION_NAME.' '.$cat->getName());
	//    $rss->description = htmlspecialchars($cat->getDescription());
	//    $rss->link = htmlspecialchars($urlIndex);
	//    $rss->syndicationURL = htmlspecialchars($urlSite.$_SERVER["REQUEST_URI"]);
	//
	//    /*
	//     $image = new FeedImage();
	//     $image->title = APPLICATION_NAME." logo";
	//     $image->url = "logo url";
	//     $image->link = $rss->link;
	//     $image->description = "Site description";
	//     $rss->image = $image;
	//     */
	//
	//    $entries = getEntriesForRss($cat->getId());
	//
	//    foreach ( $entries as $entry ) {
	//        $item = new FeedItem();
	//        $item->title = htmlspecialchars($entry->getTitle());
	//        $item->link = $urlIndex.'?'.GET_PARAM_ACTION.'='.ACTION_VIEW_ADS;
	//        $item->link .= '&'.GET_PARAM_ID.'='.$entry->getId();
	//        $item->description = htmlspecialchars($entry->getTitle());
	//        $item->date = date(DATETIME_FORMAT, $entry->getCreationTimestamp());
	//        $item->source = $urlSite;
	//        $item->author = APPLICATION_NAME;
	//
	//        $rss->addItem($item);
	//    }
	//	//$rss->createFeed("RSS1.0");
	//    $rss->saveFeed("RSS1.0");
}
?>