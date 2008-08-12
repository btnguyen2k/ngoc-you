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

if ( !function_exists('fnmatch') ) {
    function fnmatch($pattern, $string) {
        $pattern = strtr(preg_quote($pattern, '#'), array('\*' => '.*', '\?' => '.', '\[' => '[', '\]' => ']'));       
        return preg_match('#^'.$pattern.'$#i', $string);
    }
}

$IGNORE_FIRST_LEVEL = Array('.', '..', '.cache', '.settings', '.project', '.externalToolBuilders', 'test', 'phpinfo.php', 'release.php', '.svn', 'release', 'resources');
$IGNORE_SECOND_LEVEL = Array('.', '..', '.svn', '%%*.*');

function copyDir($src, $desc, $secondLevel = false) {
    global $IGNORE_FIRST_LEVEL;
    global $IGNORE_SECOND_LEVEL;

    @mkdir($desc);
    if ( !is_dir($desc) || !is_writable($desc) ) {
        echo "$desc is not a directory or not writable!\n";
        exit;
    }
    if ( $dirHandle = opendir($src) ) {
        $ignoreList = $secondLevel ? $IGNORE_SECOND_LEVEL : $IGNORE_FIRST_LEVEL;
        while ( $file = readdir($dirHandle) ) {
            $ignore = false;
            foreach ( $ignoreList as $pattern ) {
                if ( fnmatch($pattern, $file) ) {
                    $ignore = true;
                    break;
                }
            }
            if ( $ignore ) {
                continue;
            }
            if ( is_dir($src."/".$file) ) {
                mkdir($desc."/".$file);
                copyDir($src."/".$file, $desc."/".$file, true);
            } else {
                echo $desc, "/", $file, "\n";
                copy($src."/".$file, $desc."/".$file);
            }
        }
        closedir($dirHandle);
    }
}

$RELEASE_DIR = 'release';

removeTree($RELEASE_DIR, false);
@mkdir($RELEASE_DIR);
//copyDir(".", $RELEASE_DIR);
copyDir('config',    $RELEASE_DIR.'/config',    true);
copyDir('lib',       $RELEASE_DIR.'/lib',       true);
copyDir('languages', $RELEASE_DIR.'/languages', true);
copyDir('www',       $RELEASE_DIR.'/www', true);
copy(".htaccess", $RELEASE_DIR.'/www/.htaccess');
?>