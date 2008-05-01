<center>
<h1><?= $LANG['ADMIN_TITLE'] ?></h1>
</center>
<center>
<h2><?= $LANG['ADMIN_TITLE_REPORTED_ADS'] ?></h2>
</center>
<table cellpadding="4" cellspacing="1" align="center" width="75%">
	<thead>
		<tr>
			<th class="contentCell_2">Ads</th>
			<th class="contentCell_2">Category</th>
			<th class="contentCell_2">Reporter</th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach ( $PAGE['content']['reportedAds'] as $ads ) {
	    echo '<tr>';

	    echo '<td class="contentCell_1" width="65%">';
	    echo '<a href="', $_SERVER['PHP_SELF'],'?',GET_PARAM_ACTION,'=processReportedAds&id=', $ads->getId(),'">';
	    echo htmlspecialchars($ads->getEntry()->getTitle());
	    echo '</a>';
	    echo '</td>';

	    echo '<td class="contentCell_1" width="20%">';
	    echo htmlspecialchars($ads->getEntry()->getCategory()->getName());
	    echo '</td>';

	    if ( $ads->getReporter() === NULL ) {
	        echo '<td class="contentCell_1">Anonymous</td>';
	    } else {
	        echo '<td class="contentCell_1" width="15%">';
	        echo htmlspecialchars($ads->getReporter()->getLoginName());
	        echo '</td>';
	    }

	    echo '</tr>';
	}
	?>
	</tbody>
</table>
