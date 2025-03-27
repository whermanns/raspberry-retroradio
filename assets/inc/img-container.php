<?php
defined('_RETRO_RADIO') or die ('Restricted access');

switch ($scheme) {
    case 0:
        $img_id = "donau-img";
        echo "<div class='img-container'>\n";
        echo "<div id='img-pointer' class='hidden'><img src='assets/img/pointer.webp' alt='Zeiger'></div>\n";
        // Donau F, show front view
        if ($key >=1 && $key <= 8) {
            // Background for channel display
            $bg_img = "assets/img/donau-f-unscharf.webp";
            echo "<img id='$img_id' class='w100' src='$bg_img' alt='{$_schemes[$scheme][0]}'>\n";
            echo "<img id='donau-maske' class='w100 opacity0' src='assets/img/donau-f-maske.webp' alt=''>\n";
        } else {
            // Front view
            $bg_img = "assets/img/donau-f.webp";
            echo "<img id='$img_id' class='w100' src='$bg_img' alt='{$_schemes[$scheme][0]}'>\n";
        }
    break;
    case 1:
        echo "<div class='img-container'>\n";
        $bg_img = "assets/img/sirius".random_int(1,20).".jpg";
        $img_id = "sirius-img";
        echo "<img id='$img_id' class='w100' src='$bg_img' alt='{$_schemes[$scheme][0]}'>\n";
    break;
}



switch ($scheme) {
    case 0:
        for ($i = 1; $i <= 8; $i++) {
            $rstation = "";
            $rstation_id = 'rstation';
            if (isset($streams[$i-1][0])) {
                $rstation = $streams[$i-1][0];
                $rstation_id .= $i;
                echo "<label class='pointer rstation' id='$rstation_id' for='key$i'>$rstation</label>\n";
            }
        }
        break;
}
echo "</div>\n";
