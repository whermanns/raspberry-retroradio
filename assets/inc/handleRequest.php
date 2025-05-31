<?php
defined('_RETRO_RADIO') or die ('Restricted access');


// ------------------------------------------------------------------
// Set volume
// The account $_user must be included in the groups 'audio' and 'video'
// $password and $_user are defined in config.php
if (isset($_POST['volume'])) {
    $volume = $_POST['volume'];
    // Semilogarithmic characteristic curve
    $cVol = round($volume / 2 + log10($volume +1) * 25);
    $playS->setVolume($cVol);
} else {
    $volume = $sD->get('volume');
}
$volChanged = $volume != $sD->get('volume');
$sD->set('volume', $volume);


// ------------------------------------------------------------------
// Determine display scheme
$scheme = $_POST['scheme'] ?? $sD->get('scheme');
$sD->set('scheme', $scheme);


// ------------------------------------------------------------------
// Read stations list
$streamlist = new streamList($_streams_csv, $_csv_separator);


// Number of station lists ( = URLs  / 8 )
$groups = $streamlist->count_groups();

// Determine the URL of the server
$subfolder = dirname($_SERVER["SCRIPT_NAME"]);
if ($subfolder == "/") {
    $subfolder = "";
}
$_srv = $_SERVER["REQUEST_SCHEME"] . "://". $_SERVER["HTTP_HOST"] . $subfolder;

// Name of radio station
$station = "";

// URL of stream
$url = "";
if (!isset($_SESSION['url'])) {
    $_SESSION['url'] = '';
}

// ------------------------------------------------------------------
// Evaluate form
// Read out $_POST array and save in variables
$key = $_POST['key'] ?? $sD->get('key');

$group = $_POST['group'] ?? $sD->get('group');


// Determine station selection button
if (!isset($_SESSION['prevKey'])) {
    $_SESSION['prevKey'] = 0;
}
$prevKey = $_SESSION['prevKey'];

// RECORD
$record = $_POST['record'] ?? 0;
if ($key == 0 or $key != $prevKey) {
    $record = 0;
}


// RECORD


// Evaluate direct selection and convert into key commands
// Line no. in the CSV file
$stationIndex = "";
// Prevent locking of button input by direct dialling
$useStationIndex = $_POST['useStationIndex'] ?? 0;
if ($useStationIndex == 1) {
    $stationIndex = $_POST['stationIndex'] ?? "";
    // Direct selection -> Key and group index
    if ($stationIndex != "") {
        $key = $stationIndex % 8 + 1;
        $group = intdiv($stationIndex, 8) + 1;
        $_POST['stationIndex'] = "";
    }
}


// Read stream list from CSV file
/*
Array
(
    [nr] => Array
        (
            [0] => station
            [1] => url
        )
    ...
}
*/
$streams = json_decode($streamlist->get_grouped_streams($group - 1));

if (isset($key)) {
 
    // Play key click if necessary
    // $_play_key_click see config.php
    if ($_play_key_click && !$volChanged) {
        // Play key click only when key is pressed
        if ($key != $sD->get('key')) {
            $playS->playStream("$_srv/assets/audio/".$_schemes[$scheme][1], 40 );
            usleep(5E5);
        }
    }


    // Determine key number
    $sD->set('key', $key);

    // Select station
    if ($key >= 1 && $key <= 8) {

        // Avoid interruption when changing the volume
        if (!$volChanged) {
            $i = $key - 1;
            if ((isset($streams[$i]) && count($streams[$i]) > 1)) {
                $station = trim($streams[$i][0]);
                $url = trim($streams[$i][1]);
                $_SESSION['url'] = $url;
                if ($key != $_SESSION['prevKey'] or $group != $sD->get('group')) {
                    $station = $streams[$i][0];
                    if (!$playS->playStream($url, 100)) {
                        $_SESSION['url'] = "";
                        $alert_msg = lang("play_error");
                    } else {
                        $_SESSION['url'] = $url;
                    }
                }
            }
        }

        switch ($record) {
            case 1:
                if ($sD->get("record") != 1) {
                    $playS->recordStream($station, $url);
                }
                $sD->set("record", 1);
                break;
            case 0:
                if ($sD->get("record") != 0) {
                    $playS->killFfmpeg();
                }
                $sD->set("record", 0);
                break;
        }
        $sD->set("record", $record);


    } else {
        $playS->killVlc();
        $_SESSION['url'] = "";
    }
} else {
    $key = 0;
}

$_SESSION['prevKey'] = $key;
$sD->set('group', $group);