<?php
/*
Retro-Radio
Walter Hermanns, 2025
*/



// Version
$_version = "2025-03-27";


// Prevent direct call of included php files
define('_RETRO_RADIO', 1);


// Read configuration
require "config.php";


if ($_DISPLAY_ERRORS) {
    ini_set("display_errors", 1);
    ini_set("error_reporting", E_ALL);
} else {
    ini_set("display_errors", 0);
    ini_set("error_reporting", 0);
}


session_start([
    "cookie_samesite" => "",
    "use_strict_mode" => 0
]);


// Read session data
require "assets/inc/storeData.php";
$sD = new storeData();


// Base directory
$_dir = __DIR__;


// Upload file name
$_uploadFn = dirname($_streams_csv) == "." ? "$_dir/$_streams_csv" : $_streams_csv;

$_uploadFolder = dirname($_uploadFn);


// Display scheme
// 0: Saba Donau F, years of manufacture 1969 to 1976
// 1: Philips Sirius BD431A, years of manufacture 1953 to 1954
$_schemes = [
    // index => ["Caption", "Key sound"]
    0 => ["Saba Donau F", "sirius.mp3"],
    1 => ["Philips Sirius", "donau.mp3"]
];


// Error message
$alert_msg = "";


// Include language file
function getLangFile($lang) {
    // Fallback: en
    $l = "en";
    switch ($lang) {
        case "auto":
            $fn = '/etc/locale.gen';
            if (is_file($fn)) {
                $f = file_get_contents($fn);
                // Grep active language setting
                $r = '/^([a-z]*)\_/m';
                // If several are activated, the language found first is used
                preg_match($r, $f, $m);
                $l = $m[1];
            }
            break;
        default:
            $l = $lang;
    }
    $res = is_file("assets/lang/$l.php") ? "assets/lang/$l.php" : "assets/lang/en.php";

    return $res;
}

require getLangFile($_lang);


// Check login data
if (shell_exec("echo $_password | su $_user -c 'ls -la /home/$_user'") == NULL) {
    $alert_msg = lang('invalid_user');
}


// Read radio stations from csv file
require "assets/inc/streamList.php";


// Play audio stream
require "assets/inc/playStream.php";

$playS = new playStream($_user, $_password);

$_loginOk = $playS->loginOk;
if (!$_loginOk) {
    $alert_msg = lang('invalid_user');
}


// Evaluate form
require "assets/inc/handleRequest.php";


// Save CSV file
require "assets/inc/csvUpload.php";
?>
<!DOCTYPE html>
<html lang="<?php echo lang('lang')?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Retro-Radio">
    <meta name="keywords" content="Internetradio, Webradio">
    <meta name="author" content="Walter Hermanns, 2025">
    <title>Retroradio</title>
    <link rel="stylesheet" href="assets/css<?php echo $scheme;?>/style.min.css">
    <link rel="icon" type="image/vnd.microsoft.icon" href="favicon.ico">
</head>
<body class="bg fg">
<div class="container">

<?php
// Show menu
require "assets/inc/dialogs.php";

// Display image / scale
require "assets/inc/img-container.php";
?>
<form id="frm" method="POST">
<?php
// Output keypad
require "assets/inc/keyboard-container.php";

// Select station list
require "assets/inc/footer.php";


// Save session data
$sD->writeJson();


// Display error
if ($alert_msg != "") {
    $alert_msg = '\u26A0 '.lang('error').':\n'.$alert_msg;
    echo "<script>alert('$alert_msg')</script>";
}
?>
</form>
<div id="codec" class="fs-80 codec"></div>
</div>
<script>
const loginOk='<?php echo $_loginOk; // Pass PHP variables to JavaScript?>';
const url='<?php echo $_SESSION['url'];?>';
const csvName='<?php echo $_streams_csv?>';
const srv='<?php echo $_srv?>';
const scheme=<?php echo $scheme?>;
const prevKey=<?php echo $prevKey?>;
const key=<?php echo $key?>;
const csvContent=<?php echo $streamlist->get_streamlist()?>;
</script>
<script src="assets/js/script.js"></script>
</body>
</html>
