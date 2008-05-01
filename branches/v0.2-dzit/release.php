<?php
function removeTree($dir, $removeCurrent = false) {
	if ( $dirHandle = opendir($dir) ) {
		while ( $file = readdir($dirHandle) ) {
			if ( $file !== "." && $file !== ".." ) {
				if ( is_dir($dir."/".$file) ) {
					removeTree($dir."/".$file, true);
				} else {
					unlink($dir."/".$file);
				}
			}
		}
		closedir($dirHandle);
		if ( $removeCurrent ) {
			rmdir($dir);
		}
		return true;
	} else {
		return false;
	}
}

$IGNORE_FIRST_LEVEL = Array(".", "..", ".cache", ".settings", ".project", "test", "phpinfo.php", "release.php", ".svn", "release", "resources");
$IGNORE_SECOND_LEVEL = Array(".", "..", ".svn");

function copyDir($src, $desc, $secondLevel = false) {
	global $IGNORE_FIRST_LEVEL;
	global $IGNORE_SECOND_LEVEL;
	
	if ( !is_dir($desc) || !is_writable($desc) ) {
		echo "$desc is not a directory or not writable!\n";
		exit;
	}
	if ( $dirHandle = opendir($src) ) {
		while ( $file = readdir($dirHandle) ) {
			if ( in_array($file, $secondLevel?$IGNORE_SECOND_LEVEL:$IGNORE_FIRST_LEVEL) ) {
				continue;  
			}
			if ( is_dir($src."/".$file) ) {
				mkdir($desc."/".$file);
				copyDir($src."/".$file, $desc."/".$file);
			} else {
				echo $desc, "/", $file, "\n";
				copy($src."/".$file, $desc."/".$file);
			}
		}
		closedir($dirHandle);
	}
}

$RELEASE_DIR = 'release';

removeTree($RELEASE_DIR, true);
mkdir($RELEASE_DIR);
copyDir(".", $RELEASE_DIR);
copy(".htaccess", $RELEASE_DIR."/.htaccess");
?>