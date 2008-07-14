<?php
require_once 'dao/dbUtils.php';
class You_Dzit_AdminMoveupCategoryHandler extends You_Dzit_AdminHandler {

    /**
     * {@see Ddth_Dzit_ActionHandler_AbstractActionHandler::performAction()}
     */
    protected function performAction() {
        $id = isset($_GET['id']) ? $_GET['id'] + 0 : 0;
        $cat = getCategory($id);
        $tree = NULL;
        if ( $cat!==NULL && $cat->getParentId()===0 ) {
            $tree = getCategoryTree();
        } elseif ( $cat!==NULL && $cat->getParentId()!==0 ) {
            $parent = getCategory($cat->getParentId());
            $tree = $parent !== NULL ? $parent->getChildren() : NULL;
        }
        if ( $tree !== NULL ) {
            $prev = NULL;
            foreach ( $tree as $current ) {
                if ( $current->getId() === $cat->getId() ) {
                    if ( $prev !== NULL ) {
                        //higher 'position' value --> sorted on top
                        $prev->setPosition($current->getPosition());
                        $current->setPosition($current->getPosition()+1);
                        updateCategory($current);
                        updateCategory($prev);
                    }
                    break;
                }
                $prev = $current;
            }
        }
        $app = $this->getApplication();
        $urlCreator = $app->getUrlCreator();
        $url = $urlCreator->createUrl(You_Dzit_Constants::ACTION_ADMIN_CATEGORY_LIST);
        return new Ddth_Dzit_ControlForward_UrlRedirectControlForward($url);
    }
}
?>
