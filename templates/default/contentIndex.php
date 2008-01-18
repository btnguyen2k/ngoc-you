<table border="0" cellpadding="2" width="100%">
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
		<td>
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
	echo $cat->getName();
	echo " ";
}
?>
<table border="0" cellpadding="2" cellspacing="0" width="100%">
<tr>
	<td valign="top" width="50%">
		<?php
		$hasCat = false;
		for ( $i = 0, $n = count($PAGE['categoryTree']); $i < $n; $i+=2 ) {
			_displayTopCat($PAGE['categoryTree'][$i]);
			$hasCat = true;
		}
		if ( !$hasCat ) echo "&nbsp;";
		?>
	</td>
	<td valign="top" width="50%">
		<?php
		$hasCat = false;
		for ( $i = 1, $n = count($PAGE['categoryTree']); $i < $n; $i+=2 ) {
			_displayTopCat($PAGE['categoryTree'][$i]);
			$hasCat = true;
		}
		if ( !$hasCat ) echo "&nbsp;";
		?>
	</td>
</tr>
</table>