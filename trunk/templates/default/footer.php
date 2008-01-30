<pre>
<?php
	if ( DEBUG_MODE ) {
		foreach ( $DBACCESS->getSqlLog() as $sql ) {
			echo htmlspecialchars($sql);
			echo "\n";
		}
	}
?>
</pre>
</body>
</html>