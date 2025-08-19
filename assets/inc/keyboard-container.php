<?php
defined('_RETRO_RADIO') or die ('Restricted access');

echo "<div>\n";

echo "<div class='record'>";

switch ($record) {
    case 1:
        $recordImg = "tape-r-ani.webp";
        echo "<div id='recCaption'>".lang('record')."</div>\n";
        break;
    default:
        $recordImg = "tape.webp";
}

if (substr($url, 0, 4) == 'http'){
    echo "<label for='record'><input class='display-none' type='text' value='$record' id='record' name='record'>";
    echo "<img id='img-record' class='shadow' src='assets/img/$recordImg' alt='Record'></label>\n";
}

echo "</div>\n<div id='keyboard'>\n";

// Station selection buttons

for ($i=0; $i<=8; $i++) {
    $chk = "";
    if ($key == $i && $i > 0) {
        $chk = "checked";
    }

    switch ($scheme) {
        case 0:
        case 1:
            if ($i == 0) {
                $title = lang("off");
            } else {
                if (isset($streams[$i-1][0])) {
                    $title = $streams[$i-1][0];
                } else {
                    $title = "";
                }
            }
            echo "<div class='key-wrapper'><div class='key-caption'>$title</div>\n";
            echo "<div class='key-inside'>\n";
            echo "<input type='radio' name='key' class='key display-none' id='key$i' $chk value='$i'>\n";
            echo "<label for='key$i' id='lbl$i'><span class='klbl'></span></label>\n";
            echo "</div></div>\n";
        break;
    }

}
echo "</div></div>\n";