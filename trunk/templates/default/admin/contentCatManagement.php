<center><h1><?=$LANG['ADMIN_TITLE']?></h1></center>
<center><h2><?=$LANG['ADMIN_TITLE_CATEGORY_MANAGEMENT']?></h2></center>
<table cellpadding="4" cellspacing="1" align="center" width="75%">
<tr>
	<td width="60%" class="contentCell_2" align="center"><b><?=$LANG['CATEGORY']?></b></td>
	<td width="40%" class="contentCell_2" align="center" colspan="4"><b><?=$LANG['ACTIONS']?></b></td>
</tr>
<?php
foreach ( $PAGE['categoryTree'] as $cat ) {
	__displayCat($cat);
}
function __displayCat($cat, $indent=0) {
	global $LANG;
?>
<tr>
	<td class="contentCell_1" width="60%">
		<?php
		for ( $i = 0; $i < $indent; $i++ ) {
			echo "&nbsp; &nbsp; "; 
		}
		?>
		+ <a href="<?=__createCatUrlEdit($cat)?>"><?=htmlspecialchars($cat->getName())?></a>
	</td>
	<td width="10%" class="contentCell_1" align="center">
		<a href="<?=__createCatUrlEdit($cat)?>"><?=$LANG['EDIT']?></a>
	</td>
	<td width="10%" class="contentCell_1" align="center">
		<a href="<?=__createCatUrlDelete($cat)?>"><?=$LANG['DELETE']?></a>
	</td>
	<td width="10%" class="contentCell_1" align="center">
		<a href="<?=__createCatUrlMoveUp($cat)?>"><?=$LANG['MOVE_UP']?></a>
	</td>
	<td width="10%" class="contentCell_1" align="center">
		<a href="<?=__createCatUrlMoveDown($cat)?>"><?=$LANG['MOVE_DOWN']?></a>
	</td>
</tr>
<?php
	foreach ( $cat->getChildren() as $child ) {
		__displayCat($child, $indent+1);
	}
}
?>
</table>