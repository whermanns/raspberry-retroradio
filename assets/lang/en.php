<?php
defined('_RETRO_RADIO') or die ('Restricted access');

function lang($key) {
    global $_version;
    $lang = [
        "lang" => "en",
        "off" => "Off",
        "volume" => "Volume",
        "decor" => "Decor",
        "channel_group" => "Channel group",
        "direct_dial" => "Direct dial",
        "station" => "Station...",
        "group" => "Group",
        "close" => "Close",
        "cancel" => "Cancel",
        "help" => "Help",
        "selTracks" => "Select Song",
        "record" => "Record",
        "export" => "Export",
        "import" => "Import",
        "export_list" => "Export station list",
        "import_list" => "Import station list",
        "import_warn" => "The existing channel list is replaced by importing a new list.",
        "web_server_account" => "Web server account",
        "no_csv_file" => "No csv file",
        "storage_folder" => "Storage folder",
        "storage_description" => "The storage folder is defined by the variable <code>\$_streams_csv</code> in the file <code>config.php</code>.",
        "install" => "Installation",
        "error" => "Error",
        "play_error" => "Cannot play stream.",
        "import_failed" => "Import failed.",
        "write_error" => "Write error in the directory ",
        "invalid_user" => "Incorrect login data, see config.php",
        "about" => "About retro radio",
        "about_page" => "<h1>Retro radio</h1><hr><p>Author: Walter Hermanns<p>License: <a href='https://creativecommons.org/licenses/by-sa/4.0/deed.de'>cc by-sa</a><p>Version: $_version",
        "help_page" =>
        "<h1>Help menu</h1>
<hr>
<h2>Format of the station list</h2>
<p>Stations are written line by line to the <code>streams.csv</code> file.
<p>Structure of the csv file (<u>C</u>omma <u>S</u>eparated <u>V</u>alues):
<pre class='fs-70'>
NDR 2 SH,https://icecast.ndr.de/ndr/ndr2/schleswigholstein/mp3/128/stream.mp3
WDR 2,https://wdr-wdr2-rheinland.icecastssl.wdr.de/wdr/wdr2/rheinland/mp3/128/stream.mp3
WDR 5,https://wdr-wdr5-live.icecastssl.wdr.de/wdr/wdr5/live/mp3/128/stream.mp3</pre>
so:<br>
Station name,Internet address of the radio stream
<p>Streaming URLs can be found on the websites of the radio stations. Further sources for radio stream addresses:
<i><a class='a m2' href='https://fmstream.org/' target='_blank'>fmstream.org</a></i>, 
<i><a class='a m2' href='https://streamurl.link/' target='_blank'>streamurl.link</a></i>
<hr>
<h2>Playing local audio files</h2>
<p>Add folders containing audio files to the station list.
The following special characters must not be included in the file name:
<br><code>{}|&#38;&#126;:&lt;&gt;*\'&#34;?%@</code>
<p>Structure: <code>Album title,folder name</code>
<pre class='fs-70'>
Kind of Blue,/freigabe/Miles Davis/Kind Of Blue
Creedence Clearwater Revival,/freigabe/Miles Davis/Kind Of Blue</pre>
Each folder is assigned to a channel selection button. You can select one or more files in the dialog box.
<hr>
<p><button type='button' class='closeD'>Close</button>
<span class='fs-60 fright'>Walter Hermanns, 2025</span>"
    ];

    if (array_key_exists($key, $lang)) {
        return $lang[$key];
    } else {
        die ('<script>alert("Error:\nKey \''.$key.'\' is not defined in file \'assets/lang/'. $lang['lang'].'.php\'.");</script>');
    }
}
