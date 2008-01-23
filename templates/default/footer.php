<pre>
<?php
	if ( DEBUG_MODE ) {
		foreach ( $DBACCESS->getSqlLog() as $sql ) {
			echo $sql;
			echo "\n";
		}
	}
?>
</pre>
</body>
</html>