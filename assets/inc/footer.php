<?php
defined('_RETRO_RADIO') or die ('Restricted access');
?>
<div class='footer'>
    <div class="flex-v">
    <div class="fc">
        <label class="fs-80" for="volume"><?php echo lang("volume")?></label><span id="show-vol"><?php echo $volume;?></span><br>
        <input class="pointer range w120 mt4" type="range" min="0" max="100" name="volume" id="volume" value="<?php echo $volume;?>">
    </div>
    <div class="fc">
        <label class="fs-80" for="scheme"><?php echo lang("decor")?></label><br>
        <select class="pointer w120 mt4" name="scheme" id="scheme">
<?php
for ($i = 0; $i < count($_schemes); $i++) {
    $sel = "";
    if ($i == $scheme) {
        $sel = "selected";
    }
    echo "<option value='$i' $sel>{$_schemes[$i][0]}</option>\n";
}

?>
        </select>
    </div>
    </div>
    <div class="flex-v">
    <div class="fc">
        <label class="fs-80" for="group"><?php echo lang("channel_group")?></label><br>
        <select class="pointer w120 mt4" name="group" id="group">
<?php
// Select stations list
for ($i = 1; $i <= $groups; $i++) {
    $sel = "";
    if ($group == $i) {
        $sel = "selected";
    }
    echo "<option value='$i' $sel>".lang('group')." $i</option>\n";
}
?>
        </select>
    </div>

    <div class="fc">
    <?php
        if ($key > 0 && isset($streams[$key-1][0])) {
            $placeholder = $streams[$key-1][0];    
        } else {
            $placeholder = lang("station");
        }
    ?>
        <label class="fs-80" for="search"><?php echo lang("direct_dial")?></label><br> 
        <input class="w120 bg bd mt4" type="text" id="search" name="search" placeholder="<?php echo $placeholder?>" autocomplete="off">
        <input type="hidden" name="useStationIndex" id="useStationIndex">
        <input type="hidden" name="stationIndex" id="stationIndex" value="<?php echo $stationIndex?>">
        <ul id='vorschlag' class='list-frame w120'>
<?php
/*
Why so complicated when there is the HTML element <datalist>?
The Datalist element does not work with browsers on mobile devices.
*/
function dataList($names, $class='display-none') {
    $res = "";
    for ($i = 0; $i <count($names); $i++) {
        $res .= "<li class='$class li-sel'>{$names[$i]}</li>";
    }
    return $res;
}
echo dataList($streamlist->get_station_names($_streams_csv));
?>
        </ul>
    </div>

    </div>
</div>
