<?php
require_once 'dao/dbUtils.php';
class You_Dzit_AdminMovedownCategoryHandler extends You_Dzit_AdminHandler {

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
            $current = NULL;
            foreach ( $tree as $next ) {
                if ( $current!==NULL && $current->getId()===$cat->getId() ) {
                    //higher 'position' value --> sorted on top
                    $current->setPosition($next->getPosition());
                    $next->setPosition($next->getPosition()+1);
                    updateCategory($current);
                    updateCategory($next);
                    break;
                }
                $current = $next;
            }
        }
        $app = $this->getApplication();
        $urlCreator = $app->getUrlCreator();
        $url = $urlCreator->createUrl(You_Dzit_Constants::ACTION_ADMIN_CATEGORY_LIST);
        return new Ddth_Dzit_ControlForward_UrlRedirectControlForward($url);
    }
}
?>
