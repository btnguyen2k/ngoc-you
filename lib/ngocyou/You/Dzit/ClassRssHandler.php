<?php
require_once 'dao/dbUtils.php';
require_once 'includes/feedcreator.class.php';
require_once 'includes/rss10.inc';
class You_Dzit_RssHandler extends You_Dzit_BaseActionHandler {

    const NUM_ITEMS = 10;

    private $cat;

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::performAction()}
     */
    protected function performAction() {
        $id = isset($_GET['cat']) ? $_GET['cat']+0 : 0;
        $cat = getCategory($id);

        $entries = getLatestEntries(self::NUM_ITEMS, $cat!==NULL?$cat->getId():0);
        $app = $this->getApplication();
        $urlCreator = $app->getUrlCreator();
        
        $urlSite = "http://".$_SERVER["HTTP_HOST"];
        $urlIndex = "http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];
        
        $siteName = getConfig(You_Dzit_Constants::CONFIG_SITE_NAME);
        $title = $siteName;
        if ( $cat !== NULL ) {
            $title .= ' - ' . $cat->getName();
        }
        $title = htmlspecialchars($title);
        $desc = $title;
        $rss = new RSSWriter($urlIndex, $title, $desc, Array("dc:publisher" => $siteName, "dc:creator" => $siteName));
    	foreach ( $entries as $entry ) {
    	    $params = Array('id' => $entry->getId());
    	    $link = $urlCreator->createUrl(You_Dzit_Constants::ACTION_VIEW_ADS, Array(), $params, "", true);
		    $title = htmlspecialchars($entry->getTitle());
		    $desc = (strip_tags($entry->getContent()));
		    $rss->addItem($link, $title, Array("description" => $desc, "dc:creator" => $siteName));
	    }
	    $rss->preamble();
	    $rss->channelinfo();
	    $rss->image();
	    $rss->items();
	    $rss->postamble();
	    header("Content-type: application/xhtml+xml");
	    //echo '<?xml version="1.0" encoding="UTF-8"';
	    echo $rss->getxml();
        return NULL;
    }
}
?>
