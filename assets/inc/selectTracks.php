<?php
defined('_RETRO_RADIO') or die ('Restricted access');

function trackList($dir) {
    if (substr($dir, -1) != "/") {
        $dir .= "/";
    }
    
    $audioTypes = [".mp3", ".wav", ".aac", "flac", ".ogg", ".wma", ".m4a", "opus", ".mid", "midi", ".ape", ".m3u"];

    $audioFiles = [];
    if (is_dir($dir)) {
        $re = '/[{}|&#"%~:<>*\'?]/m';
        $files = scandir($dir);
        foreach ($files as $file) {
            if (substr($file, 0, 1) != "." &&
                in_array(substr($file, -4), $audioTypes))  {
                    preg_match_all($re, $file, $matches, PREG_SET_ORDER);
                    if (count(value: $matches) == 0) {
                        $audioFiles[] = $file;
                    }
            } 
        }
    }
    return $audioFiles;
}


function selectList($dir, $name, $class, $size = 6) {
    $files = trackList($dir);
    if (substr($dir, -1) != "/") {
        $dir .= "/";
    }

    $res = "<select name='$name' class='$class' size='$size' multiple>\n";
    foreach ($files as $file) {
        $bn = basename($file);

        $track = $dir.$file;
        $res .= "<option value='$track'>$bn</option>\n"; 
    }
    return "$res</select>\n";
}

if (!isset($_POST["playlist"])) {
    echo "<div class='pushOver shadow bg bd mt-4 p4'>\n";
    echo "<label class='fs-80 w240'>$streamName</label>\n<br>\n";
    echo selectList($url, "playlist[]", "w240 mt4 bd");
    echo "<br><input class='btnSubmit' type='submit' value='".lang('selTracks')."'>\n";
    echo "</div>\n";
}