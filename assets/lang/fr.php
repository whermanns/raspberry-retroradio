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
        "selTracks" => "Choisir des chansons",
        "record" => "Capture",
        "export" => "Export",
        "import" => "Importer",
        "export_list" => "Exporter la liste des stations",
        "import_list" => "Importer la liste des stations",
        "import_warn" => "La liste de chaînes existante est remplacée par l'importation d'une nouvelle liste.",
        "web_server_account" => "Compte serveur web",
        "no_csv_file" => "Pas de fichier csv",
        "storage_folder" => "Dossier mémoire",
        "storage_description" => "The storage folder is defined by the variable <code>\$_streams_csv</code> in the file <code>config.php</code>.",
        "install" => "Installation",
        "error" => "Erreur",
        "play_error" => "Impossible de lire le streaming.",
        "import_failed" => "Échec de l'importation.",
        "write_error" => "Erreur d'écriture dans le répertoire ",
        "invalid_user" => "Données de connexion incorrectes, voir config.php",
        "about" => "À propos de Retroradio",
        "about_page" => "<h1>Retroradio</h1><hr><p>Licence: Walter Hermanns<p><a href='https://creativecommons.org/licenses/by-sa/4.0/deed.de'>cc by-sa</a><p>Version: $_version",
        "help_page" =>
        "<h1>Menu Aide</h1>
<hr>
<h2>Format de la liste des stations</h2>
<p>Les émetteurs sont écrits ligne par ligne dans le fichier <code>streams.csv</code>.
Structure du fichier csv (<u>C</u>omma <u>S</u> séparées par des <u>V</u> valeurs):
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
<h2>Lecture de fichiers audio locaux</h2>
<p>Ajouter le dossier contenant les fichiers audio à la liste des stations.
Les caractères spéciaux suivants ne doivent pas figurer dans le nom du fichier:
<br><code>{}|&#38;&#126;:&lt;&gt;*\'&#34;?%@</code>
<p>Structure : <code>Titre de l'album, nom du dossier</code>
<pre class='fs-70'>
Kind Of Blue,/freigabe/Miles Davis/Kind Of Blue
Creedence Clearwater Revival,/freigabe/CCR</pre>
Chaque dossier est associé à une touche de sélection de station. Dans la boîte de dialogue, vous pouvez sélectionner un ou plusieurs fichiers.
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
