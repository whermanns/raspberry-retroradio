<?php
defined('_RETRO_RADIO') or die ('Restricted access');

function lang($key) {
    global $_version;
    $lang = [
        "lang" => "fr",
        "off" => "Arrêt",
        "volume" => "Volume",
        "decor" => "Décor",
        "channel_group" => "Groupe de stations",
        "direct_dial" => "Appel direct",
        "station" => "Station...",
        "group" => "Groupe",
        "close" => "Fermer",
        "cancel" => "Abandon",
        "help" => "Aide",
        "export" => "Export",
        "import" => "Importer",
        "export_list" => "Exporter la liste des stations",
        "import_list" => "Importer la liste des stations",
        "import_warn" => "La liste de chaînes existante est remplacée par l'importation d'une nouvelle liste.",
        "web_server_account" => "Compte serveur web",
        "no_csv_file" => "Pas de fichier csv",
        "storage_folder" => "Dossier mémoire",
        "storage_description" => "The storage folder is defined by the variable <code>\$streams_csv</code> in the file <code>config.php</code>.",
        "install" => "Installation",
        "error" => "Erreur",
        "play_error" => "Impossible de lire le streaming.",
        "create_error" => "Impossible de créer une liste de lecture.",
        "no_audio_files" => "Pas de fichiers audio dans le dossier ",
        "import_failed" => "Échec de l'importation.",
        "write_error" => "Erreur d'écriture dans le répertoire ",
        "invalid_user" => "Données de connexion incorrectes, voir config.php",
        "about" => "À propos de Retroradio",
        "about_page" => "<h1>Retroradio</h1><hr><p>Licence: Walter Hermanns<p><a href='https://creativecommons.org/licenses/by-sa/4.0/deed.de'>cc by-sa</a><p>Version: $_version",
        "help_page" =>
        "<h1>Menu Aide</h1>
<hr>
<h2>Format de la liste des stations</h2>
<p>Les stations sont sauvegardées ligne par ligne dans un fichier csv (<u>C</u>omma <u>S</u> séparées par des <u>V</u> valeurs) comme dans l'exemple suivant:
<pre class='fs-70'>
NDR 2 SH,https://icecast.ndr.de/ndr/ndr2/schleswigholstein/mp3/128/stream.mp3
WDR 2,https://wdr-wdr2-rheinland.icecastssl.wdr.de/wdr/wdr2/rheinland/mp3/128/stream.mp3
WDR 5,https://wdr-wdr5-live.icecastssl.wdr.de/wdr/wdr5/live/mp3/128/stream.mp3</pre>
so:<br>
Nom de la station,adresse Internet du flux radio
<p>Les URL de streaming se trouvent sur les sites web des stations de radio. Autres sources d'adresses de flux radio:
<i><a class='a m2' href='https://fmstream.org/' target='_blank'>fmstream.org</a></i>, 
<i><a class='a m2' href='https://streamurl.link/' target='_blank'>streamurl.link</a></i>
<hr>
<h2>Lecture d'un fichier audio local ou d'une liste de lecture</h2>
<p>Attachez des fichiers audio individuels ou des listes de lecture (extension de fichier : .m3u) à la liste des stations. Les noms de fichiers sont écrits avec des chemins d'accès absolus. Les caractères spéciaux suivants ne doivent pas être inclus dans le nom du fichier:
<br><code>{}|&#38;&#126;:&lt;&gt;*\'&#34;?%@</code>
<p>Structure : Titre de la piste musicale ou de l'album,nom complet du fichier
<pre class='fs-70'>
So What,/release/Miles Davis/Kind Of Blue/01 So What.mp3
Kind Of Blue,/share/Miles Davis/Kind Of Blue/kind_of_blue.m3u</pre>
<hr>
<h2>Create playlist</h2>
<p>Si seul le nom du dossier est indiqué, Retroradio tente de créer une liste de lecture appelée <code>retroradio.m3u</code>, 
en supposant que les droits sur le dossier sont suffisants. L'entrée est transformée en
<pre class='fs-70'>
Kind Of Blue,/share/Miles Davis/Kind Of Blue/</pre>
 est transformée en:<br>
<pre class='fs-70'>Kind Of Blue,/share/Miles Davis/Kind Of Blue/retroradio.m3u</pre>
<p>Dans la liste de lecture, les noms de fichiers des morceaux de musique sont énumérés ligne par ligne, par exemple
<pre class='fs-70'>01 So What.mp3
02 Freddie Freeloader.mp3
03 Blue In Green.mp3
04 All Blues.mp3
05 Flamenco Sketches.mp3
06 Flamenco Sketches [Alternate].mp3</pre>
<hr>
<p><button type='button' class='closeD'>Fermer</button>
<span class='fs-60 fright'>Walter Hermanns, 2025</span>"
    ];

    if (array_key_exists($key, $lang)) {
        return $lang[$key];
    } else {
        die ("Error: Key '.$key.' is not defined in file 'assets/lang/{$lang['lang']}.php\'.");
    }
}
