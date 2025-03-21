<?php
defined('_RETRO_RADIO') or die ('Restricted access');

echo "<div><div  id='keyboard'>\n";

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
            echo "<input type='radio' name='key' class='key' id='key$i' $chk value='$i'>\n";
            echo "<label for='key$i' id='lbl$i'><span class='klbl'></span></label>\n";
            echo "</div></div>\n";
        break;
    }

}
echo "</div></div>\n";