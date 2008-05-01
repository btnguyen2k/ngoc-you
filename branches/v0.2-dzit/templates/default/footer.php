<script language="javascript" type="text/javascript" src="<?='templates/'.TEMPLATE.'/'?>js/avim20071102.js"></script>
<script type="text/javascript" language="javascript">
	dauCu = 0;
	setMethod(0);
</script>
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