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
        "export" => "Export",
        "import" => "Import",
        "export_list" => "Export station list",
        "import_list" => "Import station list",
        "import_warn" => "The existing channel list is replaced by importing a new list.",
        "web_server_account" => "Web server account",
        "no_csv_file" => "No csv file",
        "storage_folder" => "Storage folder",
        "storage_description" => "The storage folder is defined by the variable <code>\$streams_csv</code> in the file <code>config.php</code>.",
        "install" => "Installation",
        "error" => "Error",
        "play_error" => "Cannot play stream.",
        "create_error" => "Cannot create playlist.",
        "no_audio_files" => "No audio files in the folder ",
        "import_failed" => "Import failed.",
        "write_error" => "Write error in the directory ",
        "invalid_user" => "Incorrect login data, see config.php",
        "about" => "About retro radio",
        "about_page" => "<h1>Retro radio</h1><hr><p>Author: Walter Hermanns<p>License: <a href='https://creativecommons.org/licenses/by-sa/4.0/deed.de'>cc by-sa</a><p>Version: $_version",
        "help_page" =>
        "<h1>Help menu</h1>
<hr>
<h2>Format of the station list</h2>
<p>Stations are saved line by line in a csv file (<u>C</u>omma <u>S</u>eparated <u>V</u>alues) as in the following example:
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
<h2>Playing a local audio file or playlist</h2>
<p>Attach individual audio files or playlists (file extension: .m3u) to the station list. File names are written with absolute paths. The following special characters must not be included in the file name:
<br><code>{}|&#38;&#126;:&lt;&gt;*\'&#34;?%@</code>
<p>Structure: Title of the music track or album, full file name
<pre class='fs-70'>
So What,/release/Miles Davis/Kind Of Blue/01 So What.mp3
Kind Of Blue,/share/Miles Davis/Kind Of Blue/kind_of_blue.m3u</pre>
<hr>
<h2>Create playlist</h2>
<p>If only the folder name is specified, Retroradio attempts to create a playlist called <code>retroradio.m3u</code>, 
assuming sufficient folder rights. The entry
<pre class='fs-70'>
Kind Of Blue,/share/Miles Davis/Kind Of Blue/</pre>
is converted to:<br>
<pre class='fs-70'>Kind Of Blue,/share/Miles Davis/Kind Of Blue/retroradio.m3u</pre>
<p>In the playlist, the file names of the music tracks are listed line by line, e.g:
<pre class='fs-70'>01 So What.mp3
02 Freddie Freeloader.mp3
03 Blue In Green.mp3
04 All Blues.mp3
05 Flamenco Sketches.mp3
06 Flamenco Sketches [Alternate].mp3</pre>
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