<pre>
<?php
	if ( DEBUG_MODE ) {
	    printf("Total queries=%d; total cached=%d.", $EXECS+$CACHED, $CACHED);
	    echo "\nExecuted queries:\n";
	    foreach ( $SQL_EXECS as $sql ) {
	        echo "- $sql\n";
	    }
	}
?>
</pre>
</body>
</html>