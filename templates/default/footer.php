<pre>
<?php
	foreach ( $DBACCESS->getSqlLog() as $sql ) {
		echo $sql;
		echo "\n";
	}
?>
</pre>
</body>
</html>