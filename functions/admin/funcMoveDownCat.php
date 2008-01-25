<?php
require_once 'includes/denyDirectInclude.php';
require_once 'includes/config.php';
require_once 'dao/dbUtils.php';

$id = isset($_GET[GET_PARAM_CATEGORY]) ? $_GET[GET_PARAM_CATEGORY] + 0 : 0;
$cat = getCategory($id);
$tree = NULL;
if ( $cat!=NULL && $cat->getParentId()==0 ) {
	$tree = getCategoryTree();
} elseif ( $cat!=NULL && $cat->getParentId()!=0 ) {
	$parent = getCategory($cat->getParentId());
	$tree = $parent != NULL ? $parent->getChildren() : NULL;
}

if ( $tree != NULL ) {
	$current = NULL;
	foreach ( $tree as $next ) {
		if ( $current!=NULL && $current->getId()==$cat->getId() ) {
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

header('Location: admin.php?'.GET_PARAM_ACTION.'='.ACTION_CAT_MANAGEMENT);
?>