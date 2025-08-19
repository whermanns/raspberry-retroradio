<?php
defined('_RETRO_RADIO') or die ('Restricted access');

function lang($key) {
    global $_version;
    $lang = [
        "lang" => "de",
        "off" => "Aus",
        "volume" => "Lautstärke",
        "decor" => "Dekor",
        "channel_group" => "Sendergruppe",
        "direct_dial" => "Direktwahl",
        "station" => "Sender...",
        "group" => "Gruppe",
        "close" => "Schließen",
        "cancel" => "Abbrechen",
        "selTracks" => "Titel auswählen",
        "help" => "Hilfe",
        "record" => "Aufnahme",
        "export" => "Exportieren",
        "import" => "Importieren",
        "export_list" => "Senderliste exportieren",
        "import_list" => "Senderliste importieren",
        "import_warn" => "Die bestehende Senderliste wird durch den Import einer neuen Liste ersetzt.",
        "web_server_account" => "Webserverkonto",
        "no_csv_file" => "Keine csv-Datei",
        "storage_folder" => "Speicherordner",
        "storage_description" => "Der Speicherordner wird mit der Variablen <code>\$_streams_csv</code> in der Datei <code>config.php</code> festgelegt.",
        "install" => "Installation",
        "error" => "Fehler",
        "play_error" => "Kann Stream nicht abspielen.",
        "import_failed" => "Import fehlgeschlagen.",
        "write_error" => "Schreibfehler im Verzeichnis ",
        "invalid_user" => "Falsche Anmeldedaten, s. config.php",
        "about" => "Über Retroradio",
        "about_page" => "<h1>Retroradio</h1><hr><p>Autor: Walter Hermanns<p>Lizenz: <a href='https://creativecommons.org/licenses/by-sa/4.0/deed.de'>cc by-sa</a><p>Version: $_version",
        "help_page" =>
        "<h1>Hilfe</h1>
<hr>
<h2>Format der Senderliste</h2>
<p>Sender werden zeilenweise in die Datei <code>streams.csv</code> geschrieben.
<br>Struktur der csv-Datei (<u>C</u>omma <u>S</u>eparated <u>V</u>alues):
<pre class='fs-70'>
NDR 2 SH,https://icecast.ndr.de/ndr/ndr2/schleswigholstein/mp3/128/stream.mp3
WDR 2,https://wdr-wdr2-rheinland.icecastssl.wdr.de/wdr/wdr2/rheinland/mp3/128/stream.mp3
WDR 5,https://wdr-wdr5-live.icecastssl.wdr.de/wdr/wdr5/live/mp3/128/stream.mp3</pre>
also:<br>Sendername,Internetadresse des Radiostreams
<p>Streaming-URLs sind auf den Webseiten der Radiosender zu finden. Weitere Bezugsquellen für Adressen von Radiostreams:
<i><a class='a m2' href='https://fmstream.org/' target='_blank'>fmstream.org</a></i>, 
<i><a class='a m2' href='https://streamurl.link/' target='_blank'>streamurl.link</a></i>
<hr>
<h2>Lokale Audiodateien abspielen</h2>
<p>Ordner mit Audiodateien in die Senderliste eintragen.
Folgende Sonderzeichen dürfen nicht im Dateinamen enthalten sein:
<br><code>{}|&#38;&#126;:&lt;&gt;*\'&#34;?%@</code>
<p>Strukur: <code>Titel des Albums,Ordnername</code>
<pre class='fs-70'>
Kind of Blue,/freigabe/Miles Davis/Kind Of Blue
Creedence Clearwater Revival,/freigabe/CCR
</pre>
Jeder Ordner ist einer Senderwahltaste zugeordnet. Im Dialog kann man eine oder mehrere Dateien auswählen.
<hr>
<p><button type='button' class='closeD'>Schließen</button>
<span class='fs-60 fright'>Walter Hermanns, 2025</span>"
    ];

    if (array_key_exists($key, $lang)) {
        return $lang[$key];
    } else {
        die ('<script>alert("Error:\nKey \''.$key.'\' is not defined in file \'assets/lang/'. $lang['lang'].'.php\'.");</script>');
    }
}
