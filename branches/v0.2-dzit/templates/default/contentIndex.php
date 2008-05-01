<table border="0" cellpadding="4" width="100%">
<tr>
	<td align="center" class="pageMainTitle"><?=APPLICATION_NAME?></td>
</tr>
</table>
<?php
function _displayTopCat($cat) {
?>	
	<table border="0" cellpadding="2" cellspacing="0" width="100%">
	<tr>
		<td class="topLvlCatTitle" align="center"><?=htmlspecialchars($cat->getName())?></td>
	</tr>
	<tr>
		<td class="catList">
			<?php
			if ( $cat->getNumChildren() > 0 ) {
				foreach ( $cat->getChildren() as $child ) {
					_displaySubCat($child);
				}
			} else {
				echo "&nbsp;";
			}					
			?>
		</td>
	</tr>
	</table>
<?php
}

function _displaySubCat($cat) {
	$catName = htmlspecialchars($cat->getName());
	if ( $cat->getNumEntries() > 0 ) {
		$catName .= '('.$cat->getNumEntries().')';
	}
	echo '<a href="'.$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_VIEW_CAT;
	echo '&'.GET_PARAM_CATEGORY.'='.$cat->getId().'">'.$catName.'</a>';
	echo " ";
}
?>
<table border="0" cellpadding="2" cellspacing="0" width="100%">
<tr>
	<?php
	$_NUM_CATS = count($PAGE['categoryTree']);
	if ( $_NUM_CATS <= 0 ) {
		echo '&nbsp;';
	} else {	
		$_NUM_COLS = 3;	
		$_COL_WIDTHS = Array();
		$totalWidth = 0;
		for ( $i = 0; $i < $_NUM_COLS-1; $i++ ) {
			$temp = intval(100/$_NUM_COLS);
			$totalWidth += $temp;
			$_COL_WIDTHS[] = $temp;		
		}
		$_COL_WIDTHS[] = 100 - $totalWidth;
		for ( $it = 0; $it < $_NUM_COLS; $it++ ) {
			$colWidth = $_COL_WIDTHS[$it];
			echo '<td valign="top" width="'.$colWidth.'%">';
			for ( $i = $it; $i < $_NUM_CATS; $i+=$_NUM_COLS ) {
				_displayTopCat($PAGE['categoryTree'][$i]);
			}
			echo '</td>';
		}
	}
	?>
</tr>
</table>