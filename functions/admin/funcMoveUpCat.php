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
	$prev = NULL;
	foreach ( $tree as $current ) {
		if ( $current->getId() == $cat->getId() ) {
			if ( $prev != NULL ) {
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

header('Location: admin.php?'.GET_PARAM_ACTION.'='.ACTION_CAT_MANAGEMENT);
?>